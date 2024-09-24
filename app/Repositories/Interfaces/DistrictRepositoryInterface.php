<?php

namespace App\Repositories\Interfaces;

/**
 * Interface DistrictRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface DistrictRepositoryInterface
{
    public function findDistrictByProvinceId(int $province_id);
    public function all();
    public function findById(int $id);

}
