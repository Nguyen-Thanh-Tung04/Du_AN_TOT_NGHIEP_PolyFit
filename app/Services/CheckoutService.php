<?php

namespace App\Services;

use App\Repositories\CheckoutRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



/**
 * Class CheckoutService
 * @package App\Services
 */
class CheckoutService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');
        $users = $this->userRepository->pagination([
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

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send', 're_password']);
            if ($payload['birthday'] != null) {
                $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            }
            $payload['password'] = Hash::make($payload['password']);
            $user = $this->userRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            if ($payload['birthday'] != null) {
                $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            }
            $user = $this->userRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
            $user = $this->userRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];
            $flag = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function findByIdUser($userId)
    {
        $userId = Auth::id();
    }

    public function calculateTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item->variant->sale_price ?? $item->variant->listed_price;
            $total += $price * $item->quantity;
        }
        return $total;
    }
}
