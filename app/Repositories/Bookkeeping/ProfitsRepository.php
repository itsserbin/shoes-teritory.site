<?php

namespace App\Repositories\Bookkeeping;

use App\Models\Bookkeeping\Profit as Model;
use Carbon\Carbon;

class ProfitsRepository extends CoreRepository
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
            'cost',
            'profit',
            'clear_profit',
            'refunds_sum',
            'sale_of_air_sum',
            'profit_without_sale_of_air',
            'turnover',
        )
            ->orderBy($sort, $param)
            ->paginate($perPage);

    }

    public function generalStatistic($date_start = null, $date_end = null, $last = null)
    {
        if ($date_start && $date_end) {
            $model = $this->model::whereBetween('date', [$date_start, $date_end])->get();
        } elseif ($last) {
            if ($last == 'week') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            } elseif ($last == 'two-week') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            } elseif ($last == 'one-month') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->startOfMonth(), Carbon::now()->endOfWeek()])->get();
            } else {
                $model = $this->model;
            }
        } else {
            $model = $this->model::all();
        }

        $result['Расходы'] = $model->sum('cost');
        $result['Прибыль без расходов'] = $model->sum('profit');
        $result['Чистая прибыль'] = $model->sum('clear_profit');
        $result['Сумма за возвраты'] = $model->sum('refunds_sum');
        $result['Оборот'] = $model->sum('turnover');
        $result['Продажи воздуха'] = $model->sum('sale_of_air_sum');
        $result['Прибыль без продаж воздуха'] = $model->sum('profit_without_sale_of_air');

        return $result;
    }

    public function getAll($date_start = null, $date_end = null, $last = null)
    {
//        if ($date_start && $date_end) {
//            return $this->model::whereBetween('date', [$date_start, $date_end])->get();
//        } elseif ($last) {
//            if ($last == 'week') {
//                return $this->model::whereBetween('date',
//                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
//            } elseif ($last == 'two-week') {
//                return $this->model::whereBetween('date',
//                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
//            } elseif ($last == 'one-month') {
//                return $this->model::whereBetween('date',
//                    [Carbon::now()->startOfMonth(), Carbon::now()->endOfWeek()])->get();
//            } else {
//                return $this->model::all();
//            }
//        } else {
//            return $this->model::all();
//        }
            return $this->model::all();
    }

    public function create($data)
    {
        $model = new $this->model;
        $model->date = $data['date'];
        return $model->save();
    }

    public function getRowByDate($date)
    {
        return $this->model::whereDate('date', $date)->first();
    }

    public function createNewModel()
    {
        return new $this->model;
    }

}
