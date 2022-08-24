<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Infrastructure\ApiResponse;
use App\Models\Animal;
use App\Models\Collect;
use App\Models\Farm;
use App\Models\KpiCard;
use App\Models\Movement;
use App\Models\MovementType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    use ApiResponse;
    public function index(Request $request) {

        try {
            $cards =  new KpiCard();
            $cards = $cards->get();

            $cards->map(function($card) {
                $count = Movement::where('movement_type_id', $card->movement_type_id)->count();
                $card->count = $count;
                return $card;
            });

            $purchases = Movement::where('movement_type_id', MovementType::COMPRA_ANIMAIS)->count();
            $sales = Movement::where('movement_type_id',  MovementType::VENDA_ANIMAIS)->count();
            $dead = Movement::where('movement_type_id', MovementType::FALECIMENTO_ANIMAIS)->count();
            $births = Movement::where('movement_type_id', MovementType::NASCIMENTO_ANIMAIS)->count();

            $farms = new Farm();
            $animals = new Animal();
            $collections = new Collect();

            $defaultCards = [
                [
                    "name" => "Number of farms",
                    "count" => $farms->count()
                ],
                [
                    "name" => "Number of collects",
                    "count" => $collections->count()
                ],
                [
                    "name" => "Number of active animals",
                    "count" => $animals->count()
                ],
                [
                    "name" => "Number of records",
                    "count" => $animals->count()
                ],
                [
                    "name" => "Number of animals purchased",
                    "count" => $purchases
                ],
                [
                    "name" => "Number of animals sold",
                    "count" => $sales
                ],
                [
                    "name" => "Number of mortalities",
                    "count" => $dead
                ],
                [
                    "name" => "Number of births",
                    "count" => $births
                ],
            ];

            $cards =  array_merge($defaultCards, $cards->toArray());

            return $this->success('All results', $cards);
        } catch (\Throwable $th) {
            return $this->error('Ocorreu um erro interno.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
