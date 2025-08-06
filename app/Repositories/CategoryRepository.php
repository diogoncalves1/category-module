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
                return response()->json(["success" => true, "message" => __('')]);
            });
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => true, "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $category = $this->show($id);

                $input = $request->only('info', 'type', 'icon', 'color', 'parent_id');

                $user = Auth::user();

                if (!$category->default && $category->user_id != $user->id || !$user->can('createDefaultCategory'))
                    throw new UnauthorizedDefaultCategoryException();

                $category->update($input);

                return response()->json(['success' => true, 'message' => __('')]);
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function destroy(string $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $category = $this->show($id);

                $user = Auth::user();

                if (!$category->default && $category->user_id != $user->id || !$user->can('createDefaultCategory'))
                    throw new UnauthorizedDefaultCategoryException();

                $category->delete();

                response()->json(["success" => true, "message" => __('')]);
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function show(string $id)
    {
        return Category::find($id);
    }

    public function dataTable(Request $request)
    {
        $query = Category::with('parent');
        $user = Auth::user();
        $userLang = /* $_COOKIE['lang'] ?? */ 'en';

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where("name", 'like', "{$search}%")
                    ->orWhere("type", 'like', "{$search}%");
            });
        }

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir');
        if ($orderColumn && $orderDir) {
            $query->orderBy($orderColumn, $orderDir);
        }


        if (!$request->get('default') && $user) {
            $query->userId($user->id);
        }


        $categories = $query->offset($request->start)
            ->limit($request->length)
            ->default($request->get('default'))
            ->select("id", 'info as name', 'info', 'parent_id', "type", 'icon', 'color')
            ->get();

        $total = $query->count();

        foreach ($categories as &$category) {

            $category->name = ($category->default) ?
                optional(json_decode($category->info))->{$userLang}->name : optional(json_decode($category->info))->name;

            if ($category->parent)
                $category->parentName = (optional($category->parent)->default) ?
                    json_decode($category->parent->info)->{$userLang}->name : json_decode($category->parent->info)->name;
            else
                $category->parentName = null;

            $category->type = __("frontend." . $category->type);
            $category->actions = "<div class='btn-group'>
                                    <a type='button' href='" . route('categories.edit', $category->id) . "' class='btn mr-1 btn-default'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                    <button type='button' onclick='modalDelete({$category->id})' class='btn btn-default'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                  </div>";
        }

        $data = [
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $categories
        ];

        return $data;
    }
}