<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\MovementServiceInterface;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * @var MovementServiceInterface
     */
    protected MovementServiceInterface $service;

    public function __construct(MovementServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function import(Request $request)
    {
        $animals = [];

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $type = $file->getClientOriginalExtension();
            $real_path = $file->getRealPath();
            $animals = $this->csvToArray($real_path, ';');
        }

        $animalsFormated = array_map(fn ($value) =>
        [
            'earring' => $value['brinco'] ?? '',
            'iron' => $value['ferro'] ?? '',
            'breed' => $value['raca'] ?? '',
            'weight' => $value['peso'] ?? '',
            'note' => $value['nota'] ?? '',
        ], $animals);

        $array = [
            'movement_type_id' => $request->movement_type_id,
            'movement_date' => $request->movement_date,
            'farm_id' => $request->farm_id,
            'collect' => [
              'movement_date' => $request->movement_date,
              'name' => $request['collect']['name'],
              'amount' =>  $request['collect']['amount'] ?? 0,
              'freight' => $request['collect']['freight'] ?? 0,
              'other_values' => $request['collect']['other_values'],
              'arroba_price' => $request['collect']['arroba_price']  ?? 0 ,
              'animals' => $animalsFormated,
            ],
        ];

        if(isset($request->destination_farm_id)){
            $array['destination_farm_id'] = $request->destination_farm_id;
        }

        return $this->service->import($array);

    }
}
