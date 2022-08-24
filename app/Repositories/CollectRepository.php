<?php

namespace App\Repositories;

use App\Infrastructure\Repository\BaseRepository;
use App\Models\Collect;
use App\Repositories\Interfaces\CollectRepositoryInterface;

class CollectRepository extends BaseRepository implements CollectRepositoryInterface
{
    public function __construct(Collect $model)
    {
        parent::__construct($model);
    }

    public function movements($collectId)
    {
        $collect = $this->model->find($collectId);
        $movements =  $collect->movements;
        if($collect) return $this->success('All results', $collect->movements);

        return $this->responseNotFound();
    }
}
