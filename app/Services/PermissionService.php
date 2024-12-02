<?php

namespace App\Services;

use App\Models\Variant;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository) {
        $this->permissionRepository = $permissionRepository;
    }

    public function paginate($request) {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perPage = $request->integer('perpage');
        $permissions = $this->permissionRepository->pagination([
            'permissions.id',
            'permissions.name',
            'permissions.canonical',
        ], $condition, $perPage, ['id', 'DESC'], [], ['path' => 'permission/index']);
        return $permissions;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payloadPermission = $request->only([
                'name',
                'canonical',
            ]);
            $permission = $this->permissionRepository->create($payloadPermission);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request) {
        DB::beginTransaction();
        try {
            $permission = $this->permissionRepository->findById($id);
       
            $payloadPermission = $request->only([
                'name',
                'canonical',
            ]);
            $flagUpdatePermission = $this->permissionRepository->update($id, $payloadPermission);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $permission = $this->permissionRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroyVariant($request) {
        DB::beginTransaction();
        try {
            $delVariantId = $request->input('delete_variant_id');
            if (isset($delVariantId)) {
                $arrVariantIds = explode(',', rtrim($delVariantId, ','));
                $deleteVariants = $this->permissionRepository->deleteVariantById('id', $arrVariantIds);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatus($post = []) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1)?2:1);
            $permission = $this->permissionRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatusAll($post) {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $flag = $this->permissionRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }
    
}