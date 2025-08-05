<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements RepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $input = $request->only(['', '', '', '']);
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            return DB::transaction(function () {});
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function destroy(string $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $category = $this->show($id);
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function show(string $id)
    {
        return Category::find($id);
    }
}