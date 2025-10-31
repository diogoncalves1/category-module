<?php

namespace Modules\Category\Repositories;

use App\Http\Controllers\ApiController;
use App\Repositories\RepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Category\Exceptions\CannotDeleteDefaultCategoryException;
use Modules\Category\Exceptions\CannotDeleteOthersCategoryException;
use Modules\Category\Exceptions\CannotUpdateDefaultCategoryException;
use Modules\Category\Exceptions\CannotUpdateOthersCategoryException;
use Modules\Category\Exceptions\UnauthorizedDefaultCategoryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Category\Entities\Category;
use Modules\User\Entities\User;

class CategoryRepository extends ApiController implements RepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function allAdmin()
    {
        return Category::default(1)->get();
    }

    public function allUser(User $user)
    {
        $categories =  Category::default(1)
            ->orWhere('user_id', $user->id)
            ->get();

        $userLang = $user->preferences->lang;

        foreach ($categories as &$category) {
            $category->name = $category->name->{$userLang} ?? $category->name;
        }

        return $categories;
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $input = $request->only(['type', 'icon', 'color', 'parent_id']);

            $user = Auth::user() ? Auth::user() : $request->user();

            $input["name"] = $request->get('name');

            if (!$request->get('default')) {
                $input['user_id'] = $user->id;
            } else {
                if (!$user || !$user->can('createDefaultCategory'))
                    throw new UnauthorizedDefaultCategoryException();
                $input['default'] = 1;
            }

            $category = Category::create($input);

            Log::info('Category ' . $category->id . ' successfully created.');
            return $category;
        });
    }

    public function update(Request $request, string $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $category = $this->show($id);

                $input = $request->only(['type', 'icon', 'color', 'parent_id']);

                $input["name"] = json_encode($request->get('name'));

                $user = Auth::user();

                if (!$user || !$category->default  && $category->user_id != $user->id)
                    throw new CannotUpdateOthersCategoryException();

                if ($category->default && !$user->can('updateDefaultCategory'))
                    throw new CannotUpdateDefaultCategoryException();

                $category->update($input);

                return response()->json(['success' => true, 'message' => __('alerts.categoryUpdated')]);
            });
        } catch (\Exception $e) {
            Log::error($e);
            if ($e->getCode())
                return response()->json(['error' => true, "message" => $e->getMessage()], $e->getCode());
            return response()->json(['error' => true, 'message' => __('alerts.errorUpdateCategory')], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $category = $this->show($id);

                $user = Auth::user();

                if (!$user || !$category->default  && $category->user_id != $user->id)
                    throw new CannotDeleteOthersCategoryException();
                if ($category->default && !$user->can('destroyDefaultCategory'))
                    throw new CannotDeleteDefaultCategoryException();

                $category->delete();

                return response()->json(["success" => true, "message" => __('alerts.categoryDeleted')]);
            });
        } catch (\Exception $e) {
            Log::error($e);
            if ($e->getCode())
                return response()->json(['error' => true, "message" => $e->getMessage()], $e->getCode());
            return response()->json(["success" => true, "message" => __('alerts.errorDeleteCategory')], 500);
        }
    }

    public function show(string $id)
    {
        return Category::find($id);
    }

    public function showUser(Request $request, string $id)
    {
        $user = Auth::user() ? Auth::user() : $request->user();

        $category = $this->show($id);

        if (!$category->default && $user->id !== $category->user_id)
            throw new AuthorizationException('This action is unauthorized');

        return $category;
    }
}
