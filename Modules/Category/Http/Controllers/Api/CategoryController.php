<?php

namespace Modules\Category\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Category\DataTables\CategoryDataTable;
use Modules\Category\Http\Requests\CategoryGuestRequest;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Category\Repositories\CategoryRepository;

class CategoryController extends ApiController
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     * @param CategoryDataTable $dataTable
     * @return JsonResponse
     */
    public function index(CategoryDataTable $dataTable): JsonResponse
    {
        try {
            return $dataTable->ajax();
        } catch (\Exception $e) {
            return $this->fail(__('exceptions.generic'), $e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryGuestRequest $request
     * @return JsonResponse
     */
    public function store(CategoryGuestRequest $request): JsonResponse
    {
        try {
            $category = $this->repository->store($request);

            return $this->ok(new CategoryResource($category), __('category::messages.categories.store', $category->name));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->fail($e->getMessage(), $e, $e->getCode());
        }
    }

    /**
     * Show the specified resource.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $id)
    {
        try {
            $category = $this->repository->showUser($request, $id);

            return $this->ok(new CategoryResource($category));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->fail($e->getMessage(), $e, $e->getCode());
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $response = $this->repository->update($request, $id);

        return $response;
    }

    public function destroy(string $id): JsonResponse
    {
        $response = $this->repository->destroy($id);

        return $response;
    }
}
