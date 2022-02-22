<?php

namespace App\Repositories\Bookkeeping;

use App\Models\Bookkeeping\Costs\Costs as Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CostsRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getById($id)
    {
        return $this->model::find($id);
    }

//    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15)
//    {
//        return $this
//            ->model::select(
//                'id',
//                'date',
//                'cost_category_id',
//                'quantity',
//                'sum',
//                'total',
//                'comment',
//                'user_id',
//            )
//            ->with('user', 'category')
//            ->orderBy($sort, $param)
//            ->paginate($perPage);
//    }

    public function getAllWithPaginate($date_start = null, $date_end = null, $last = null, $perPage = 15, string $sort = 'date', string $param = 'desc',)
    {
        if ($date_start && $date_end) {
            $model = $this->model::whereBetween('date', [$date_start, $date_end]);
        } elseif ($last) {
            if ($last == 'week') {
                $model = $this->model::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($last == 'two-week') {
                $model = $this->model::whereBetween('date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($last == 'one-month') {
                $model = $this->model::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfWeek()]);
            } else {
                $model = $this->model;
            }
        } else {
            $model = $this->model;
        }

        return $model->select(
            'id',
            'date',
            'cost_category_id',
            'quantity',
            'sum',
            'total',
            'comment',
            'user_id',
        )
            ->with('user', 'category')
            ->orderBy($sort, $param)
            ->paginate($perPage);

    }

    public function generalStatistic($date_start = null, $date_end = null)
    {
        $costCategoriesRepository = new CostCategoriesRepository();
        $list = $costCategoriesRepository->list();
        if ($date_start && $date_end) {
            $model = $this->model::whereBetween('date', [$date_start, $date_end])
                ->get();
        } else {
            $model = $this->model::all();
        }
        $result = [];
        foreach ($model as $item) {
            if (!isset($result['Всего'])) {
                $result['Всего'] = 0;
            }
            $result['Всего'] += $item->total;
            foreach ($list as $listItem) {
                if ($item->cost_category_id == $listItem->id) {
                    if (!isset($result[$listItem->title])) {
                        $result[$listItem->title] = 0;
                    }
                    $result[$listItem->title] += $item->total;
                }
            }
        }
        return $result;
    }

    public function create($data)
    {
        $model = new $this->model;
        $model->comment = $data['comment'];
        $model->quantity = $data['quantity'];
        $model->sum = $data['sum'];
        $model->date = $data['date'];
        $model->user_id = Auth::id();
        $model->total = $data['total'];
        $model->cost_category_id = $data['cost_category_id'];

        return $model->save();
    }

    public function update($id, $data)
    {
        $model = $this->getById($id);
        $model->comment = $data['comment'];
        $model->quantity = $data['quantity'];
        $model->sum = $data['sum'];
        $model->date = $data['date'];
        $model->user_id = Auth::id();
        $model->total = $data['total'];
        $model->cost_category_id = $data['cost_category_id'];

        return $model->update();
    }

    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }


}
