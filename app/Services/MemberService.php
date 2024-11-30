<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository) {
        $this->memberRepository = $memberRepository;
    }

    public function getUserCatalogue() {
        $getUserCatalogue = $this->memberRepository->getCatalogue(
            'App\Models\userCatalogue',['id','name']
        );
        return $getUserCatalogue;
    }
    public function getAllMember() {
        
        $users = $this->memberRepository->getAllMember();
        return $users;
    }

    public function paginate($request) {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $users = $this->memberRepository->pagination([
            'id',
            'name',
            'image',
            'email',
            'phone',
            'address',
            'publish',
            'user_catalogue_id',
        ], $condition, $perPage, ['path' => 'user/index']);
        return $users;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send', 're_password']);
            if ($payload['birthday'] != null) {
                $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            }
            $payload['password'] = Hash::make($payload['password']);
            $user = $this->memberRepository->create($payload);
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
            $payload = $request->except(['_token', 'send']);
            if ($payload['birthday'] != null) {
                $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            }
            $user = $this->memberRepository->update($id, $payload);
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
            $user = $this->memberRepository->delete($id);
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
            $user = $this->memberRepository->update($post['modelId'], $payload);

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
            $flag = $this->memberRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();die();
            return false;
        }
    }

    private function convertBirthdayDate($birthday = '') {
        $formatBirthday = Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday = $formatBirthday->format('Y-m-d H:i:s');

        return $birthday;
    }



}
