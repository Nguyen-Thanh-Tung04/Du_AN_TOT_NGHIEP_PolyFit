<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Voucher;
use App\Models\Variant;
use Faker\Provider\Base;

/**
 * Class VoucherRepository
 * @package App\Repositories
 */
class VoucherRepository
{
    public function findById($id) {
        return Voucher::findOrFail($id);
    }

    public function update(int $id = 0, array $payload = []) {
        $model = $this->findById($id);
        return $model->update($payload);
    }
}
