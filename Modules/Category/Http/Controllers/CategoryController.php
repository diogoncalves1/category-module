<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Session;
use Modules\Category\Repositories\CategoryRepository;

class CategoryController extends AppController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        Session::flash('page', 'categories');

        return view('category::frontend.categories.index');
    }

    public function create()
    {
        Session::flash('page', 'categories');

        $categories = $this->categoryRepository->allUser();

        return view('category::frontend.categories.form', compact('categories'));
    }

    public function edit(string $id)
    {
        Session::flash('page', 'categories');

        $category = $this->categoryRepository->show($id);

        $categories = $this->categoryRepository->allUser();

        return view('category::frontend.categories.form', compact('category', 'categories'));
    }
}
