<?php

namespace App\Repositories\ACL;

use App\Infrastructure\ApiResponse;
use App\Infrastructure\Repository\BaseRepository;
use App\Models\Profile;
use App\Repositories\ACL\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{

    use ApiResponse;

    /**
     * @var Profile
     */
    public function __construct(Profile $model)
    {
        parent::__construct($model);
    }


}
