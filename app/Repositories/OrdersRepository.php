<?php

namespace App\Repositories;

use App\Models\Enum\MassActions;
use App\Models\Enum\OrderStatus;
use App\Models\Orders as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class OrdersRepository
 * @package App\Repositories
 */
class OrdersRepository extends CoreRepository
{

    private $promoCodesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->promoCodesRepository = app(PromoCodesRepository::class);
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
     * @return Builder|Builder[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        return $this
            ->startConditions()
            ->with('items.product.providers', 'client', 'manager')
            ->find($id);
    }

    /**
     * Вывести все продукты в пагинации по 15 шт.
     *
     * @param string $sort
     * @param string $param
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15): LengthAwarePaginator
    {
        $columns = [
            'id',
            'status',
            'waybill',
            'client_id',
            'comment',
            'total_count',
            'total_price',
            'updated_at',
            'created_at',
        ];

        return $this
            ->model::with('client')
            ->select($columns)
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    /**
     * @param array $data
     * @param int $perPage
     * @return mixed
     */
    public function filter(array $data, int $perPage = 15)
    {
        $columns = [
            'id',
            'status',
            'client_id',
            'waybill',
            'comment',
            'total_price',
            'total_count',
            'updated_at',
        ];

        return $this
            ->model::with('client')
            ->where('status', $data['by'])
            ->select($columns)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Создание нового заказа.
     *
     * @param $city
     * @param $postalOffice
     * @param $client_id
     * @param $promoCode
     * @param $items
     * @return mixed
     */
    public function create($city, $postalOffice, $client_id, $promoCode, $comment, $items)
    {
        $order = new $this->model;

        $order->city = $city;
        $order->postal_office = $postalOffice;
        $order->client_id = $client_id;
        $order->status = 'Новый';
        $order->promo_code = $promoCode;
        $order->comment = $comment;

        $totalPrice = 0;
        $totalCount = 0;

        foreach ($items as $item) {
            if ($item->product) {
                $totalPrice += ($item->product->discount_price ?: $item->product->price) * $item->count;
                $totalCount += $item->count;
            }
        }

        if ($promoCode) {
            $discount = $this->promoCodesRepository->getDiscount($promoCode);

            if ($discount->discount_in_hryvnia) {
                $totalPrice -= $discount->discount_in_hryvnia;
            } elseif ($discount->percent_discount) {
                $totalPrice = $totalPrice * (100 - $discount->percent_discount) / 100;
            }
        }

        $order->total_count = $totalCount;
        $order->total_price = $totalPrice;

        $order->save();

        return $order;
    }

    public function find(int $id)
    {
        return $this->model::where('id', $id)->with('items', 'items.product')->first();
    }

    /**
     * Обновить данные клиента.
     *
     * @param int $id
     * @param array $data
     * @return Builder|Builder[]|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->status = $data['status'];
        $model->comment = $data['comment'];
        $model->city = $data['city'];
        $model->waybill = $data['waybill'];
        $model->postal_office = $data['postal_office'];
        $model->manager_id = $data['manager_id'];
        $model->parcel_reminder = $data['parcel_reminder'];

        $model->sale_of_air = $data['sale_of_air'];

        $orderItemsRepository = new OrderItemsRepository;
        $price = $orderItemsRepository->sumOrderTotalPriceById($id);

        if ($data['sale_of_air']) {
            $model->sale_of_air_price = $data['sale_of_air_price'];
            $model->total_price = $price - $data['sale_of_air_price'];
        } else {
            $model->sale_of_air_price = null;
            $model->total_price = $price;
        }

        $model->update();

        return $model;

    }

    /**
     * Удалить клиента из базы.
     *
     * @param int $id
     * @return int
     */
    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }

    /**
     * Посчитать кол-во клиентов за сегодня.
     *
     * @return mixed
     */
    public function countOrdersToday()
    {
        return $this
            ->startConditions()
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->count();
    }

    /**
     * Искать совпадения по базе по: ID, Имя и телефон.
     *
     * @param $search
     * @param null $perPage
     * @return mixed
     */
    public function search($search, $perPage = null)
    {
        $columns = [
            'id',
            'status',
            'product_id',
            'client_id',
            'created_at',
            'updated_at',
        ];

        return $this
            ->startConditions()
            ->select($columns)
            ->where('waybill', 'LIKE', "%$search%")
            ->orWhere('id', 'LIKE', "%$search%")
            ->orWhere('comment', 'LIKE', "%$search%")
            ->orderBy('created_at', 'desc')
            ->with('client')
            ->paginate($perPage);
    }

    /**
     * Подсчитать сумму всех заказов пользователя, с учетом нового заказа.
     *
     * @param $phone
     * @param $sale_price
     * @return mixed
     */
    public function sumAllClientOrders($phone, $sale_price)
    {
        return $this
                ->startConditions()
                ->where('phone', $phone)
                ->sum('sale_price') + $sale_price;
    }

    /**
     * Получить все номера телефонов из заказа.
     *
     * @return mixed
     */
    public function getAllPhones()
    {
        return $this->model::select('phone', 'created_at')->orderBy('created_at')->get();
    }

    public function massActions($action, $data): bool
    {
        if ($action == MassActions::DESTROY) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::DESTROY) {
                    $this->model::destroy($item);
                }
            }
            return true;
        }
        return false;
    }

    public function updateSmsWaybillStatus($id)
    {
        return $this->model::where('id', $id)->update(['sms_waybill_status' => 1]);
    }

    public function updateOnAddOrderTotalPriceAndCount($id, $count, $price)
    {
        $model = $this->getById($id);
        $model->total_price += $price;
        $model->total_count += $count;
        $model->update();
        return $model;
    }

    public function updateOnDestroyOrderTotalPriceAndCount($id, $count, $price)
    {
        $model = $this->getById($id);
        $model->total_price -= $price;
        $model->total_count -= $count;
        $model->update();
        return $model;
    }

    public function sumOrdersCount($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)->where('manager_id', $manager_id)->count();
        } else {
            return $this->model::whereDate('created_at', $date)->count();
        }
    }

    public function sumDoneOrdersCount($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', OrderStatus::STATUS_DONE],
                    ['manager_id', $manager_id],
                ])
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_DONE)
                ->count();
        }
    }

    public function sumCancelOrdersCount($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', OrderStatus::STATUS_CANCELED],
                    ['manager_id', $manager_id],
                ])
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_CANCELED)
                ->count();
        }
    }

    public function sumReturnedApplications($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', OrderStatus::STATUS_RETURN],
                    ['manager_id', $manager_id],
                ])
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_RETURN)
                ->count();
        }
    }

    public function countWithParcelReminder($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', '!=', OrderStatus::STATUS_CANCELED],
                    ['manager_id', $manager_id],
                    ['parcel_reminder', 1],
                ])
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', '!=', OrderStatus::STATUS_CANCELED],
                    ['parcel_reminder', 1],
                ])
                ->count();
        }
    }

    public function countWithoutParcelReminder($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', '!=', OrderStatus::STATUS_CANCELED],
                    ['manager_id', $manager_id],
                    ['parcel_reminder', 0],
                ])
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', '!=', OrderStatus::STATUS_CANCELED],
                    ['parcel_reminder', 0],
                ])
                ->count();
        }
    }

    public function sumIndefiniteApplications($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where('manager_id', $manager_id)
                ->where('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER)
                ->orWhere(function ($query) {
                    $query
                        ->where('status', OrderStatus::STATUS_PROCESSED)
                        ->where('status', OrderStatus::STATUS_ON_THE_ROAD)
                        ->where('status', OrderStatus::STATUS_AWAITING_PREPAYMENT)
                        ->where('status', OrderStatus::STATUS_NEW);
                })
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER)
                ->orWhere(function ($query) {
                    $query
                        ->where('status', OrderStatus::STATUS_PROCESSED)
                        ->where('status', OrderStatus::STATUS_ON_THE_ROAD)
                        ->where('status', OrderStatus::STATUS_AWAITING_PREPAYMENT)
                        ->where('status', OrderStatus::STATUS_NEW);
                })
                ->count();
        }
    }


}
