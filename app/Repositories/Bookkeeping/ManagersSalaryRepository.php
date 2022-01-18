<?php

namespace App\Repositories\Bookkeeping;

use App\Models\ManagerSalary as Model;
use App\Repositories\OrderItemsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\UsersRepository;

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
        $result['all'] = $this->model::where('manager_id', null)->paginate(15);
        $result['sumApplications'] = $this->sumApplications();
        $result['sumAdditionalSales'] = $this->sumAdditionalSales();
        $result['sumPriceApplications'] = $this->sumPriceApplications();
        $result['sumCanceledApplications'] = $this->sumCanceledApplications();
        $result['sumAdditionalSalesMarginality'] = $this->ordersItemsRepository->sumAdditionalSalesMarginality();
        $result['sumTotalPrice'] = $this->sumTotalPrice();
        return $result;
    }

    public function sumApplications($id = null)
    {
        if ($id) {
            return $this->model::where('manager_id', $id)->sum('applications');
        } else {
            return $this->model::where('manager_id', null)->sum('applications');
        }
    }

    public function sumCanceledApplications($id = null)
    {
        if ($id) {
            return $this->model::where('manager_id', $id)->sum('canceled_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('canceled_applications');
        }
    }

    public function sumPriceApplications($id = null)
    {
        if ($id) {
            return $this->model::where('manager_id', $id)->sum('sum_price_applications');
        } else {
            return $this->model::where('manager_id', null)->sum('sum_price_applications');
        }
    }

    public function sumAdditionalSales($id = null)
    {
        if ($id) {
            return $this->model::where('manager_id', $id)->sum('additional_sales');
        } else {
            return $this->model::where('manager_id', null)->sum('additional_sales');
        }
    }


    public function sumTotalPrice($id = null)
    {
        if ($id) {
            return $this->model::where('manager_id', $id)->sum('total_price');
        } else {
            return $this->model::where('manager_id', null)->sum('total_price');
        }
    }

    public function addDay($data)
    {
        foreach ($this->usersRepository->getManagersList() as $item) {
            $modelManager = $this->createNewModel();
            $modelManager->date = $data['date'];
            $modelManager->manager_id = $item->id;
            $modelManager->applications = $this->ordersRepository->sumOrdersCount($data['date'], $item->id);
            $modelManager->done_applications = $this->ordersRepository->sumDoneOrdersCount($data['date'], $item->id);
            $modelManager->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($data['date'], $item->id);
            $modelManager->additional_sales = $this->ordersRepository->sumAdditionalSales($data['date'], $item->id);

            if ($modelManager->applications < 50) {
                $modelManager->sum_price_applications = $modelManager->applications * 13;
            }

            $modelManager->sum_price_additional_sales = $this->ordersItemsRepository->sumAdditionalSalesMarginality($data['date'],$item->id) * 0.2;
            $modelManager->total_price = $modelManager->sum_price_additional_sales + $modelManager->sum_price_applications;
            $modelManager->save();
        }

        $model = $this->createNewModel();
        $model->date = $data['date'];
        $model->applications = $this->ordersRepository->sumOrdersCount($data['date']);
        $model->done_applications = $this->ordersRepository->sumDoneOrdersCount($data['date']);
        $model->canceled_applications = $this->ordersRepository->sumCancelOrdersCount($data['date']);
        $model->additional_sales = $this->ordersRepository->sumAdditionalSales($data['date']);

        if ($model->applications < 50) {
            $model->sum_price_applications = $model->applications * 13;
        }
        $model->sum_price_additional_sales = $this->ordersItemsRepository->sumAdditionalSalesMarginality($data['date']) * 0.2;
        $model->total_price = $model->sum_price_additional_sales + $model->sum_price_applications;
        $model->save();

        return $model;
    }
}
