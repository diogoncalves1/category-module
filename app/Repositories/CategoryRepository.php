<?php

namespace App\Repositories;

use App\Exceptions\UnauthorizedDefaultCategoryException;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                $input = $request->only(['info', 'type', 'icon', 'color', 'parent_id']);
                $user = Auth::user();

                if (!$request->get('default')) {
                    $input['user_id'] = $user->id;
                    $input['default'] = 0;
                } else {
                    if (!$user->can('createDefaultCategory'))
                        throw new UnauthorizedDefaultCategoryException();
                    $input['default'] = 1;
                }

                $category = Category::create($input);

                Log::info('Category ' . $category->id . ' successfully created.');
                return response()->json(["success" => true, "message" => '']);
            });
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, "message" => $e->getMessage()], $e->getCode());
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