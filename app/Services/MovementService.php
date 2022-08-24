<?php

namespace App\Services;

use App\Infrastructure\ApiResponse;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Collect;
use App\Models\Farm;
use App\Models\Iron;
use App\Models\Movement;
use App\Models\MovementType;
use App\Services\Interfaces\MovementServiceInterface;
use Exception;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class MovementService implements MovementServiceInterface
{
    use ApiResponse;

    protected Movement $repository;
    protected Collect $collectRepository;
    protected Animal $animalRepository;
    protected MovementType $movementTypeRepository;
    protected Farm $farmRepository;
    protected Breed $breedRepository;
    protected Iron $ironRepository;

    public function __construct(
        Movement $repository,
        Collect $collectRepository,
        Animal $animalRepository,
        MovementType $movementTypeRepository,
        Farm $farmRepository,
        Breed $breedRepository,
        Iron $ironRepository
    ) {
        $this->repository = $repository;
        $this->collectRepository = $collectRepository;
        $this->animalRepository = $animalRepository;
        $this->movementTypeRepository = $movementTypeRepository;
        $this->farmRepository = $farmRepository;
        $this->breedRepository = $breedRepository;
        $this->ironRepository = $ironRepository;
    }

    public function getAll()
    {
        $collect = $this->repository->with('animal')->with('collect')->get();
        return $this->success('All Results',  $collect, HttpResponse::HTTP_OK);
    }

    public function getById($id)
    {
    }

    public function create(array $attributes)
    {
        $farm = $this->farmRepository->find($attributes['farm_id']);

        if (!$farm) {
            return $this->error('Farm not found', HttpResponse::HTTP_NOT_FOUND);
        }

        $movementType = $this->movementTypeRepository->find($attributes['movement_type_id']);

        if (!$movementType) {
            return $this->error('Movement Type not found', HttpResponse::HTTP_NOT_FOUND);
        }

        if (!isset($attributes['collect']['animals']) || !is_array($attributes['collect']['animals']) || count($attributes['collect']['animals']) == 0) {
            return $this->error('Array of animals is empty', HttpResponse::HTTP_NOT_FOUND);
        }

        if ($movementType->operation == MovementType::ENTRADA) {
            return $this->createEntry($farm, $movementType, $attributes);
        }

        if ($movementType->operation == MovementType::SAIDA) {
            return $this->createExit($farm, $movementType, $attributes);
        }

        if ($movementType->operation == MovementType::TRANSFERENCIA_SAIDA) {
            $destinationfarm = $this->farmRepository->find($attributes['destination_farm_id']);
            return $this->createOutgoingTransfer($farm, $destinationfarm, $movementType, $attributes);
        }

        if ($movementType->operation == MovementType::AVALIACAO) {
            return $this->createMonitoring($farm, $movementType, $attributes);
        }
    }

    public function createMonitoring(Farm $farm, MovementType $movementType, array $data)
    {
        try {
            DB::beginTransaction();

            $data['collect']['movement_date'] = $data['movement_date'];
            $collect = $this->collectRepository->create($data['collect']);
            $animals = $data['collect']['animals'];

            foreach ($animals as $animal) {
                $animal['farm_id'] = $farm->id;
                $animalFind = $this->animalRepository
                    ->where('earring', $animal['earring'])->where('farm_id', $farm->id)->first();

                $movement = [
                    'operation' => $movementType->operation,
                    'movement_date' => $data['movement_date'],
                    'movement_type_id' =>  $movementType->id,
                    'movement_name' => $movementType->name,
                    'farm_id' => $farm->id,
                    'collect_id' => $collect->id,
                    'weight' => $animal['weight'],
                    'note' => $animal['note'] ?? '',
                    'moves_animals' => false,
                ];

                if (!$animalFind) {
                    $movement['is_animal'] = false;
                    $movement['note'] = 'Brinco não encontrado';
                } else {
                    $movement['animal_id'] = $animalFind->id;
                }

                $this->repository->create($movement);
            }
            DB::commit();
            return $this->success('Monitoring created', [], HttpResponse::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createEntry(Farm $farm, MovementType $movementType, array $attributes)
    {
        try {
            DB::beginTransaction();

            $attributes['collect']['movement_date'] = $attributes['movement_date'];
            $collect = $this->collectRepository->create($attributes['collect']);

            $animals = $attributes['collect']['animals'];
            $wheightTotal = array_sum(array_column($animals, 'weight'));

            $movements = [];

            if ($this->hasAnimals($farm->id, array_column($animals, 'earring'))) {
                throw new Exception("Animal já existe!");
            }

            array_walk($animals, fn (&$animal) => $animal['farm_id'] = $farm->id);

            foreach ($animals as $animal) {
                $priceAnimal = 0;

                if ($wheightTotal != 0) {
                    $priceAnimal = $collect->amount / $wheightTotal * $animal['weight'];
                }

                $newAnimal = $this->animalRepository->create($animal);

                $attributes['weight'] = $animal['weight'];
                $attributes['note'] = $animal['note'] ?? '';
                $attributes['price'] = $priceAnimal;

                $movements[] = $this->formatMovementBeforeInsert($farm, $movementType, $collect, $attributes, $newAnimal);
            }
            $result = $collect->movements()->createMany($movements);
            DB::commit();
            return $this->success('Entry created',  $result, HttpResponse::HTTP_CREATED);
        } catch (Exception $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    private function createExit(Farm $farm, MovementType $movementType, array $attributes)
    {
        try {
            DB::beginTransaction();

            $attributes['collect']['movement_date'] =  $attributes['movement_date'];
            $collect = $this->collectRepository->create($attributes['collect']);
            $animals = $attributes['collect']['animals'];
            $wheightTotal = array_sum(array_column($animals, 'weight'));

            foreach ($animals as $animal) {

                $priceAnimal = $collect->amount / $wheightTotal * $animal['weight'];

                $animalFind = null;
                if (isset($animal['animal_id'])) {
                    $animalFind = $this->animalRepository
                        ->where('id', $animal['animal_id'])->first();
                }

                if (isset($animal['earring'])) {
                    $animalFind = $this->animalRepository
                        ->where('earring', $animal['earring'])->first();
                }

                $attributes['message'] = '';
                $attributes['weight'] = $animal['weight'];
                $attributes['note'] = $animal['note'];
                $attributes['price'] = $priceAnimal;

                $movement = $this->formatMovementBeforeInsert($farm, $movementType, $collect, $attributes, $animalFind);

                if ($animalFind) {
                    $animalFind->update(['active' => false, 'weight' => $animal['weight']]);
                    $animalFind->delete();
                }

                $this->repository->create($movement);
            }

            DB::commit();
            return $this->success('Exit created', HttpResponse::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createOutgoingTransfer(Farm $farm, Farm $farmDestination, MovementType $movementType, array $attributes)
    {
        try {
            DB::beginTransaction();
            $message = "Transferência de saída para a fazenda: {$farmDestination->id}-{$farmDestination->name}";
            $collect = array_merge(['farm_id' => $farm->id, 'movement_date' => $attributes['movement_date'], 'name' => $attributes['collect']['name'] ?? $message], $attributes['collect']);
            $collect = $this->collectRepository->create($collect);

            $movement = [];

            if ($movementType->operation != MovementType::TRANSFERENCIA_SAIDA) {
                return $this->error('Movimentação inválida', HttpResponse::HTTP_BAD_REQUEST);
            }

            $animals = $attributes['collect']['animals'];

            foreach ($animals as $animal) {
                $animalFind = $this->animalRepository
                    ->where('earring', $animal['earring'])->where('farm_id', $farm->id)->first();

                $attributes['message'] = $message;
                $attributes['weight'] = $animal['weight'];
                $attributes['note'] = $animal['note'] ?? null;

                $movement = $this->formatMovementBeforeInsert($farm, $movementType, $collect, $attributes, $animalFind);

                if ($animalFind) {
                    $animalFind->update(['farm_id' => $farmDestination->id, 'weight' => $animal['weight']]);
                }

                $this->repository->create($movement);
            }

            $movementTypeEntry = $this->movementTypeRepository->find(4);
            $this->createInboundTransfer($farmDestination, $farm, $movementTypeEntry, $attributes);

            DB::commit();
            return $this->success('Outgoing Transfer created', HttpResponse::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    private function createInboundTransfer(Farm $farm, Farm $FarmOrigin, MovementType $movementType, array $attributes)
    {
        try {
            DB::beginTransaction();
            $message = "Transferência de entrada com fazenda de origem: {$FarmOrigin->id}-{$FarmOrigin->name}";

            $collect = [
                'farm_id' => $farm->id,
                'name' => $message,
                'movement_date' => $attributes['movement_date'],
                'amount' => $attributes['collect']['amount'],
                'freight' => $attributes['collect']['freight'],
                'other_values' => $attributes['collect']['other_values'],
                'arroba_price' => $attributes['collect']['arroba_price'],
            ];

            $collect = $this->collectRepository->create($collect);

            if ($movementType->operation != MovementType::TRANSFERENCIA_ENTRADA) {
                return $this->error('Movimentação inválida', HttpResponse::HTTP_BAD_REQUEST);
            }

            $animals = $attributes['collect']['animals'];

            foreach ($animals as $animal) {
                $animalFind = $this->animalRepository
                    ->where('earring', $animal['earring'])->where('farm_id', $farm->id)->first();

                $attributes['message'] = $message;
                $attributes['weight'] = $animal['weight'];
                $attributes['note'] = $animal['note'];

                $movement = $this->formatMovementBeforeInsert($farm, $movementType, $collect, $attributes, $animalFind);
                $movement['origin_farm_id'] = $FarmOrigin->id;

                $this->repository->create($movement);
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), HttpResponse::HTTP_BAD_REQUEST);
        }
    }

    public function deleteMovementByCollect($collectId)
    {
        try {

            $collect = $this->collectRepository->find($collectId);

            if (!$collect) {
                return $this->error('Collect Not Found', HttpResponse::HTTP_NOT_FOUND);
            }

            //verificar se é transferencias de saída
            //se for, deletar também as transferencias de entrada
            $movements = $this->repository->where('collect_id', $collectId)->get();

            foreach ($movements as $movement) {
                if ($movement->ype == MovementType::TRANSFERENCIA_SAIDA) {
                    $movementOrigin = $this->repository->where('origin_farm_id', $movement->farm_id)
                        ->where('collect_id', $movement->collect_id)
                        ->where('movement_type_id', MovementType::TRANSFERENCIA_ENTRADA)
                        ->first();

                    if ($movementOrigin) {
                        $movementOrigin->delete();
                    }
                }
            }

            return $this->success('Movement Deletede', HttpResponse::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function import($data)
    {
        if (!$this->hasBreeds(array_unique(array_column($data['collect']['animals'], 'breed')))) {
            return $this->error("Raça não existe!", HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!$this->hasIrons(array_unique(array_column($data['collect']['animals'], 'iron')))) {
            return $this->error("Ferro não existe!", HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data['collect']['animals'] = $this->arrayCSVFormatFromAnimals($data['collect']['animals'] );

        return $this->create($data);
    }

    /**
     * @return array
     */
    private function formatMovementBeforeInsert(Farm $farm, MovementType $movementType, Collect $collect, array $attributes, ?Animal $animalFind)
    {
        $movement = [
            'farm_id' => $farm->id,
            'collect_id' => $collect->id,
            'movement_type_id' => $movementType->id,
            'movement_name' => $movementType->name,
            'movement_date' =>  $attributes['movement_date'],
            'operation' => $movementType->operation,
            'weight' => $attributes['weight'],
            'note' => $attributes['note'] ?? $attributes['message'],
        ];

        if (!$animalFind) {
            if ($movementType->operation != MovementType::TRANSFERENCIA_ENTRADA && $movementType->operation != MovementType::ENTRADA) {
                $movement['is_animal'] = false;
                $movement['note'] = 'Brinco não encontrado';
            }
        } else {
            $movement['animal_id'] = $animalFind->id;
        }
        return $movement;
    }

    private function hasAnimals($farmId, array $earrings)
    {
        return Animal::whereIn('earring', $earrings)->where('farm_id', $farmId)->count() > 0;
    }

    private function hasBreeds(array $breedName)
    {
        return Breed::whereIn('name', $breedName)->count() > 0;
    }

    private function hasIrons(array $ironName)
    {
        return Iron::whereIn('name', $ironName)->count() > 0;
    }

    public function arrayCSVFormatFromAnimals(array $data)
    {
        return array_map(function ($animal) {
            $breed = Breed::where('name', $animal['breed'])->first();
            $animal['breed_id'] = $breed->id;

            $iron = Iron::where('name', $animal['iron'])->first();
            $animal['iron_id'] = $iron->id;

            unset($animal['iron'], $animal['breed']);
            return $animal;
        }, $data);
    }

    public function update($id, array $attributes)
    {
        // return $this->repository->update($id, $attributes);
    }

    public function delete($id)
    {
        // return $this->repository->delete($id);
    }


    function getAllPaginate($n)
    {
        // return $this->repository->getAllPaginate($n);
    }
}
