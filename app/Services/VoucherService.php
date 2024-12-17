<?php

namespace App\Services;

use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class VoucherService
 * @package App\Services
 */
class VoucherService
{
    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository) {
        $this->voucherRepository = $voucherRepository;
    }

    public function updateStatus($post = []) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1)?2:1);
            $voucher = $this->voucherRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
    
}