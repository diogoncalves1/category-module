<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        Session::flash('page', 'categories');

        return view('frontend.categories.index');
    }

    public function create()
    {
        Session::flash('page', 'categories');

        $categories = $this->categoryRepository->allUser();

        return view('frontend.categories.form', compact('categories'));
    }

    public function edit(string $id)
    {
        Session::flash('page', 'categories');

        $category = $this->categoryRepository->show($id);

        $categories = $this->categoryRepository->allUser();

        return view('frontend.categories.form', compact('category', 'categories'));
    }
}
