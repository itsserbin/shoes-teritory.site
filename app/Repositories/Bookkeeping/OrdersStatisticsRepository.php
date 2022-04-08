<?php

namespace App\Repositories\Bookkeeping;

use App\Models\Bookkeeping\OrdersStatistic as Model;
use Carbon\Carbon;

class OrdersStatisticsRepository extends CoreRepository
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
            'applications',
            'unprocessed',
            'completed',
            'refunds',
            'cancel',
            'at_the_post_office',
            'in_process',
            'transferred_to_supplier',
            'awaiting_dispatch',
            'awaiting_prepayment',
            'on_the_road',
            'received_parcel_ratio',
            'returned_orders_ratio',
            'canceled_orders_rate',
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
            $model = $this->model::all();
        }

        $result['Всего заявок'] = $model->sum('applications');
        $result['Новые'] = $model->sum('unprocessed');
        $result['Выполненные'] = $model->sum('completed');
        $result['Возвраты'] = $model->sum('refunds');
        $result['Отмененные'] = $model->sum('cancel');
        $result['На почте'] = $model->sum('at_the_post_office');
        $result['В процессе'] = $model->sum('in_process');
        $result['Переданы поставщику'] = $model->sum('transferred_to_supplier');
        $result['Ожидание предоплаты'] = $model->sum('awaiting_prepayment');
        $result['Ожидание отправки'] = $model->sum('awaiting_dispatch');
        $result['В дороге'] = $model->sum('on_the_road');

        return $result;
    }

    public function generalIndicatorsStatistic($date_start = null, $date_end = null, $last = null)
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
            $model = $this->model::all();
        }

        $result['COR (Отмененные)'] = round($model->average('canceled_orders_rate'));
        $result['ROR (Возвраты)'] = round($model->average('returned_orders_ratio'));
        $result['RPT (Выполненные)'] = round($model->average('received_parcel_ratio'));

        return $result;
    }

    public function getAll()
    {
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
