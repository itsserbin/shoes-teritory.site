<?php

namespace App\Repositories\Bookkeeping;

use App\Models\Bookkeeping\MarketingStatistic as Model;
use Carbon\Carbon;

class MarketingStatisticRepository extends CoreRepository
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
            'average_application_price',
            'average_approve_application_price',
            'average_done_application_price',
            'average_check',
            'average_marginality',
            'average_items',
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
            'average_application_price',
            'average_approve_application_price',
            'average_done_application_price',
            'average_check',
            'average_marginality',
            'average_items',
        )
            ->orderBy('date','desc')
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
            }else {
                $model = $this->model;
            }
        } else {
            $model = $this->model::all();
        }

        $result['Ср.цена заявки'] = $model->average('average_application_price');
        $result['Ср.цена апрува'] = $model->average('average_approve_application_price');
        $result['Ср.цена выполненной заявки'] = $model->average('average_done_application_price');
        $result['Ср.чек'] = $model->average('average_check');
        $result['Ср.маржа'] = $model->average('average_marginality');
        $result['Ср.кол-во товара'] = $model->average('average_items');

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
