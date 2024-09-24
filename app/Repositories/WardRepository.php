<?php

namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\Interfaces\WardRepositoryInterface;

/**
 * Class WardRepository
 * @package App\Repositories
 */
class WardRepository implements WardRepositoryInterface
{
    protected $model;
    public function __construct(Ward $model) {
        $this->model = $model;
    }

}
