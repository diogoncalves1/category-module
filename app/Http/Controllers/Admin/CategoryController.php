<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Language;
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

        $categories = $this->categoryRepository->allAdmin();

        $languages = Language::cases();

        return view('admin.categories.form', compact('categories', 'languages'));
    }

    public function edit(string $id)
    {
        // $this->allowedAction('editCategory');

        Session::flash('page', 'categories');

        $category = $this->categoryRepository->show($id);

        $categories = $this->categoryRepository->allAdmin();

        $languages = Language::cases();

        return view('admin.categories.form', compact('category', 'categories', 'languages'));
    }
}
