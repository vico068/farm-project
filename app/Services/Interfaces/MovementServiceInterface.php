<?php
namespace App\Services\Interfaces;

use App\Infrastructure\Interfaces\BaseCRUDInterface;
use App\Models\Farm;
use App\Models\MovementType;

interface MovementServiceInterface extends BaseCRUDInterface {

    public function createMonitoring(Farm $farm, MovementType $movementType, array $data);

    public function import(array $attributes);

}
