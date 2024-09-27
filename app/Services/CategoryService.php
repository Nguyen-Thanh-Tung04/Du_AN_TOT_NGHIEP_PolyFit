<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryInterface as CategoryRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class CategoryService.
 */
class CategoryService
{
    protected $CategoryRepository;

    public function __construct(
        CategoryRepository $CategoryRepository
    ) {
        $this->CategoryRepository = $CategoryRepository;
    }
    public function paginate($request)
    {

        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = $request->integer('perpage');

        $CategoryRepository = $this->CategoryRepository->pagination([
            'id',
            'code',
            'name',
            'image',
            'is_active'
        ], $condition, $perPage);

        return $CategoryRepository;
    }
}
