<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoryResource;
use App\Repositories\Categories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var $repository
     */
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return CategoryResource::collection($this->repository->all());
    }

    public function items(Request $request){
        $search = [
            'name' => $request->input('name')
        ];

        return CategoryResource::collection($this->repository->items($search));
    }
}
