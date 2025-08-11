<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use Modules\Category\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Session;
use Modules\Category\Enums\Language;

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

        return view('category::admin.categories.index');
    }

    public function create()
    {
        // $this->allowedAction('addCategory');

        Session::flash('page', 'categories');

        $categories = $this->categoryRepository->allAdmin();

        $languages = Language::cases();

        return view('category::admin.categories.form', compact('categories', 'languages'));
    }

    public function edit(string $id)
    {
        // $this->allowedAction('editCategory');

        Session::flash('page', 'categories');

        $category = $this->categoryRepository->show($id);

        $categories = $this->categoryRepository->allAdmin();

        $languages = Language::cases();

        return view('category::admin.categories.form', compact('category', 'categories', 'languages'));
    }
}
