<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\DataTables\CategoryDataTable;

class CategoryController extends AppController
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function index(CategoryDataTable $dataTable)
    {
        $this->allowedAction('viewCategoryDefault');

        return $dataTable->render('category::admin.index');
    }

    public function create()
    {
        $this->allowedAction('createCategoryDefault');

        $categories = $this->repository->allAdmin();
        $languages = config('languages');

        return view('category::admin.create', compact('categories', 'languages'));
    }

    public function edit(string $id)
    {
        $this->allowedAction('editCategoryDefault');

        $category = $this->repository->show($id);
        $categories = $this->repository->allAdmin();
        $languages = config('languages');

        return view('category::admin.create', compact('category', 'categories', 'languages'));
    }
}
