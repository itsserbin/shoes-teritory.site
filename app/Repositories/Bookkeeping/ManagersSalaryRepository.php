<?php

namespace App\Repositories\Bookkeeping;

use App\Models\ManagerSalary as Model;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\UsersRepository;
use Carbon\Carbon;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ManagersSalaryRepository extends CoreRepository
{
    private $ordersItemsRepository;
    private $usersRepository;
    private $ordersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(OrdersRepository::class);
        $this->ordersItemsRepository = app(OrderItemsRepository::class);
        $this->usersRepository = app(UsersRepository::class);
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке.
     *
     * @param int @id
     *
     * @return Model
     */
    public function getById($id)
    {
        return $this
            ->startConditions()
            ->find($id);
    }

    public function getRowsByDate($date)
    {
        return $this->model::whereDate('date', $date)->get();
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function createNewModel()
    {
        return new $this->model;
    }

    public function getAllStatistics()
    {
        $result['all'] = $this->model::where('manager_id', null)->orderBy('date', 'desc')->paginate(15);

        $result['countInProcessApplications'] = $this->countInProcessApplications();
        $result['sumReturnedApplications'] = $this->sumReturnedApplications();
        $result['sumTotalApplications'] = $this->sumTotalApplications();
        $result['countApplications'] = $this->countApplications();
        $result['countAdditionalSales'] = $this->countAdditionalSales();
        $result['sumCanceledApplications'] = $this->sumCanceledApplications();
        $result['sumDoneApplications'] = $this->sumDoneApplications();
        $result['sumAdditionalSales'] = $this->sumAdditionalSales();
        $result['sumPriceApplications'] = $this->sumPriceApplications();
        $result['sumPriceAdditionalSales'] = $this->sumPriceAdditionalSales();
        $result['sumTotalPrice'] = $this->sumTotalPrice();
        return $result;
    }

    public function getAllStatisticsByTheNumberOfDays($days)
    {
        $result['all'] = $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
            ->where('manager_id', null)->orderBy('date', 'desc')->paginate(15);

        $result['countInProcessApplications'] = $this->countInProcessApplicationsByTheNumberOfDays($days);
        $result['sumReturnedApplications'] = $this->sumReturnedApplicationsByTheNumberOfDays($days);
        $result['sumTotalApplications'] = $this->sumTotalApplicationsByTheNumberOfDays($days);
        $result['countApplications'] = $this->countApplicationsByTheNumberOfDays($days);
        $result['countAdditionalSales'] = $this->countAdditionalSalesByTheNumberOfDays($days);
        $result['sumCanceledApplications'] = $this->sumCanceledApplicationsByTheNumberOfDays($days);
        $result['sumDoneApplications'] = $this->sumDoneApplicationsByTheNumberOfDays($days);
        $result['sumAdditionalSales'] = $this->sumAdditionalSalesByTheNumberOfDays($days);
        $result['sumPriceApplications'] = $this->sumPriceApplicationsByTheNumberOfDays($days);
        $result['sumPriceAdditionalSales'] = $this->sumPriceAdditionalSalesByTheNumberOfDays($days);
        $result['sumTotalPrice'] = $this->sumTotalPriceByTheNumberOfDays($days);
        return $result;
    }

    public function getAllStatisticsByDateRange($data)
    {
        $result['all'] = $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
            ->where('manager_id', null)->orderBy('date', 'desc')->paginate(15);

        $result['countInProcessApplications'] = $this->countInProcessApplicationsByDateRange($data);
        $result['sumReturnedApplications'] = $this->sumReturnedApplicationsByDateRange($data);
        $result['sumTotalApplications'] = $this->sumTotalApplicationsByDateRange($data);
        $result['countApplications'] = $this->countApplicationsByDateRange($data);
        $result['countAdditionalSales'] = $this->countAdditionalSalesByDateRange($data);
        $result['sumCanceledApplications'] = $this->sumCanceledApplicationsByDateRange($data);
        $result['sumDoneApplications'] = $this->sumDoneApplicationsByDateRange($data);
        $result['sumAdditionalSales'] = $this->sumAdditionalSalesByDateRange($data);
        $result['sumPriceApplications'] = $this->sumPriceApplicationsByDateRange($data);
        $result['sumPriceAdditionalSales'] = $this->sumPriceAdditionalSalesByDateRange($data);
        $result['sumTotalPrice'] = $this->sumTotalPriceByDateRange($data);
        return $result;
    }

    public function getAllStatisticsByManager($manager_id)
    {
        $result['all'] = $this->model::where('manager_id', $manager_id)->orderBy('date', 'desc')->paginate(15);

        $result['countInProcessApplications'] = $this->countInProcessApplications($manager_id);
        $result['sumReturnedApplications'] = $this->sumReturnedApplications($manager_id);
        $result['sumTotalApplications'] = $this->sumTotalApplications($manager_id);
        $result['countApplications'] = $this->countApplications($manager_id);
        $result['countAdditionalSales'] = $this->countAdditionalSales($manager_id);
        $result['sumCanceledApplications'] = $this->sumCanceledApplications($manager_id);
        $result['sumDoneApplications'] = $this->sumDoneApplications($manager_id);
        $result['sumAdditionalSales'] = $this->sumAdditionalSales($manager_id);
        $result['sumPriceApplications'] = $this->sumPriceApplications($manager_id);
        $result['sumPriceAdditionalSales'] = $this->sumPriceAdditionalSales($manager_id);
        $result['sumTotalPrice'] = $this->sumTotalPrice($manager_id);
        return $result;
    }

    public function getAllStatisticsByManagerAndDateRange($data)
    {
        $result['all'] = $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
            ->where('manager_id', $data['manager'])->orderBy('date', 'desc')->paginate(15);

        $result['countInProcessApplications'] = $this->countInProcessApplicationsByDateRange($data, $data['manager']);
        $result['sumReturnedApplications'] = $this->sumReturnedApplicationsByDateRange($data, $data['manager']);
        $result['sumTotalApplications'] = $this->sumTotalApplicationsByDateRange($data, $data['manager']);
        $result['countApplications'] = $this->countApplicationsByDateRange($data, $data['manager']);
        $result['countAdditionalSales'] = $this->countAdditionalSalesByDateRange($data, $data['manager']);
        $result['sumCanceledApplications'] = $this->sumCanceledApplicationsByDateRange($data, $data['manager']);
        $result['sumDoneApplications'] = $this->sumDoneApplicationsByDateRange($data, $data['manager']);
        $result['sumAdditionalSales'] = $this->sumAdditionalSalesByDateRange($data, $data['manager']);
        $result['sumPriceApplications'] = $this->sumPriceApplicationsByDateRange($data, $data['manager']);
        $result['sumPriceAdditionalSales'] = $this->sumPriceAdditionalSalesByDateRange($data, $data['manager']);
        $result['sumTotalPrice'] = $this->sumTotalPriceByDateRange($data, $data['manager']);
        return $result;
    }

    public function countApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('count_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('count_applications');
        }
    }

    public function countApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('count_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('count_applications');
        }
    }

    public function countApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('count_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('count_applications');
        }
    }

    public function sumCanceledApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('canceled_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('canceled_applications');
        }
    }

    public function sumCanceledApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('canceled_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('canceled_applications');
        }
    }

    public function sumCanceledApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('canceled_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('canceled_applications');
        }
    }

    public function sumReturnedApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('returned_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('returned_applications');
        }
    }

    public function sumReturnedApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('returned_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('returned_applications');
        }
    }

    public function sumReturnedApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('returned_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('returned_applications');
        }
    }

    public function sumDoneApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('done_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('done_applications');
        }
    }

    public function sumDoneApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('done_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('done_applications');
        }
    }

    public function sumDoneApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('done_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('done_applications');
        }
    }

    public function sumTotalApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('total_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('total_applications');
        }
    }

    public function sumTotalApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('total_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('total_applications');
        }
    }

    public function sumTotalApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('total_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('total_applications');
        }
    }

    public function sumAdditionalSales($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('sum_additional_sales');
        } else {
            return $this->model::where('manager_id', null)->sum('sum_additional_sales');
        }
    }

    public function sumAdditionalSalesByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('sum_additional_sales');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('sum_additional_sales');
        }
    }

    public function sumAdditionalSalesByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('sum_additional_sales');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('sum_additional_sales');

        }
    }

    public function sumPriceApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('sum_price_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('sum_price_applications');
        }
    }

    public function sumPriceApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('sum_price_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('sum_price_applications');

        }
    }

    public function sumPriceApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('sum_price_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('sum_price_applications');
        }
    }

    public function sumPriceAdditionalSales($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('sum_price_additional_sales');
        } else {
            return $this->model::where('manager_id', null)->sum('sum_price_additional_sales');
        }
    }

    public function sumPriceAdditionalSalesByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('sum_price_additional_sales');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('sum_price_additional_sales');
        }
    }

    public function sumPriceAdditionalSalesByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('sum_price_additional_sales');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('sum_price_additional_sales');
        }
    }

    public function countAdditionalSales($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('count_additional_sales');
        } else {
            return $this->model::where('manager_id', null)->sum('count_additional_sales');
        }
    }

    public function countAdditionalSalesByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('count_additional_sales');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('count_additional_sales');
        }
    }

    public function countAdditionalSalesByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('count_additional_sales');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('count_additional_sales');
        }
    }


    public function sumTotalPrice($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('total_price');
        } else {
            return $this->model::where('manager_id', null)->sum('total_price');
        }
    }

    public function sumTotalPriceByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('total_price');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('total_price');
        }
    }

    public function sumTotalPriceByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('total_price');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('total_price');
        }
    }

    public function countInProcessApplications($manager_id = null)
    {
        if ($manager_id) {
            return $this->model::where('manager_id', $manager_id)->sum('in_process_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('in_process_applications');
        }
    }

    public function countInProcessApplicationsByTheNumberOfDays($days, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', $manager_id)
                ->sum('in_process_applications');
        } else {
            return $this->model::whereDate('date', '>=', Carbon::today()->subDays($days)->format('Y-m-d'))
                ->where('manager_id', null)
                ->sum('in_process_applications');
        }
    }

    public function countInProcessApplicationsByDateRange($data, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', $manager_id)
                ->sum('in_process_applications');
        } else {
            return $this->model::whereBetween('date', [$data['date_start'], $data['date_end']])
                ->where('manager_id', null)
                ->sum('in_process_applications');
        }
    }

    public function addDay($data)
    {
        foreach ($this->usersRepository->getManagersList() as $item) {
            $model = $this->createNewModel();
            $model->date = $data['date'];
            $model->manager_id = $item->id;
            $model->save();
        }

        $model = $this->createNewModel();
        $model->date = $data['date'];
        $model->manager_id = null;
        $model->save();
    }
}
