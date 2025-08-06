<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends AppController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store(Request $request)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function dataTable(Request $request)
    {
        // $this->allowedAction('getCategories');

        $request->merge(['default' => 1]);

        $data = $this->categoryRepository->dataTable($request);

        return response()->json($data);
    }

    public function dataTableUser(Request $request)
    {
        $request->merge(['default' => 0]);

        $data = $this->categoryRepository->dataTable($request);

        return response()->json($data);
    }
}