<?php

namespace Modules\FinancialGoal\DataTables;

use Modules\Category\Entities\Category;
use Yajra\DataTables\Services\DataTable;

class FinancialGoalDataTable extends DataTable
{

    public function dataTable($query)
    {
        $request = request();

        $user = $request->user();

        return datatables()
            ->eloquent($query)
            ->editColumn('type', fn($row) => __('category::attributes.categories.type.' . $row->status))
            ->addColumn('parent', fn($row) => $row->parent)
            ->addColumn('actions', function ($category) use ($user) {

                $canEdit = $category->default ? $user->can('editCategoryDefault') : $user->id == $category->id;
                $canDestroy = $category->default ? $user->can('destroyCategoryDefault') : $user->id == $category->id;

                return ['edit' => $canEdit, 'destroy' => $canDestroy];
            });
    }

    public function query(Category $model)
    {
        $request = request();

        $user = $request->user();

        return $model->newQuery()
            ->userId('user_id', $user->id)
            ->orWhere('default', 1);
    }
}
