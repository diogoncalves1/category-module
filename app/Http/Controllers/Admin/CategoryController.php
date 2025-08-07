<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Session;

class CategoryController extends AppController
{
    private CategoryRepository $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
        // $this->allowedAction('viewCategories');

        Session::flash('page', 'categories');

        return view('admin.categories.index');
    }

    public function create()
    {
        // $this->allowedAction('addCategory');

        Session::flash('page', 'categories');

        return view('admin.categories.form');
    }

    public function edit(string $id)
    {
        // $this->allowedAction('editCategory');

        Session::flash('page', 'categories');

        $category = $this->categoryRepository->show($id);

        return view('admin.categories.form', compact('category'));
    }
}
