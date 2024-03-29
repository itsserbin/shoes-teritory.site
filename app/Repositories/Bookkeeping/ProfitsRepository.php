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
            } elseif ($last == '7-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(7), Carbon::now()]);
            } elseif ($last == '14-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(14), Carbon::now()]);
            } elseif ($last == '30-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(30), Carbon::now()]);
            } elseif ($last == '90-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(90), Carbon::now()]);
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
            'marginality',
            'average_marginality',
            'clear_profit',
            'refunds_sum',
            'sale_of_air_sum',
            'prepayment_sum',
            'additional_sales_sum',
            'additional_sales_marginality_sum',
            'debt_supplier',
            'turnover',
        )
            ->orderBy($sort, $param)
            ->paginate($perPage);

    }

    public function getDataForChart($date_start = null, $date_end = null, $last = null)
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
            } elseif ($last == '7-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(7), Carbon::now()]);
            } elseif ($last == '14-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(14), Carbon::now()]);
            } elseif ($last == '30-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(30), Carbon::now()]);
            } elseif ($last == '90-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(90), Carbon::now()]);
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
            'marginality',
            'average_marginality',
            'clear_profit',
            'refunds_sum',
            'sale_of_air_sum',
            'prepayment_sum',
            'additional_sales_sum',
            'additional_sales_marginality_sum',
            'debt_supplier',
            'turnover',
        )
            ->orderBy('date', 'desc')
            ->get();

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
            } elseif ($last == '7-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(7), Carbon::now()])->get();
            } elseif ($last == '14-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(14), Carbon::now()])->get();
            } elseif ($last == '30-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(30), Carbon::now()])->get();
            } elseif ($last == '90-days') {
                $model = $this->model::whereBetween('date',
                    [Carbon::now()->subDays(90), Carbon::now()])->get();
            } else {
                $model = $this->model;
            }
        } else {
            $model = $this->model::all();
        }

        $result['Расходы'] = $model->sum('cost');
        $result['Оборот'] = $model->sum('turnover');
        $result['Маржа'] = $model->sum('marginality');
        $result['Чистая прибыль'] = $model->sum('clear_profit');
        $result['Должен поставщик'] = $model->sum('debt_supplier');
        $result['Продажи воздуха'] = $model->sum('sale_of_air_sum');
        $result['Средняя маржа'] = $model->avg('average_marginality');
        $result['Сумма предоплат'] = $model->sum('prepayment_sum');
        $result['Сумма за возвраты'] = $model->sum('refunds_sum');
        $result['Сумма доп.продаж'] = $model->sum('additional_sales_sum');
        $result['Маржа доп.продаж'] = $model->sum('additional_sales_marginality_sum');

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

    public function averageMarginalityByDate($date)
    {
        return $this->model::whereDate('date', $date)
            ->select('average_marginality')
            ->average('average_marginality');
    }
}
