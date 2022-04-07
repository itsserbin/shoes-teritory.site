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
            'created_at',
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
     * @param $comment
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
            $model->total_price = $price + $data['sale_of_air_price'];
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
     * @param $param
     * @param $value
     * @param null $perPage
     * @return mixed
     */
    public function search($param, $value, $perPage = null)
    {
        $columns = [
            'id',
            'waybill',
            'comment',
            'status',
            'client_id',
            'created_at',
            'updated_at',
        ];


        if ($param == 'id') {
            return $this
                ->model::select($columns)
                ->where('id', $value)
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } elseif ($param == 'phone') {
            return $this
                ->model::select($columns)
                ->whereHas('client', function ($q) use ($value) {
                    $q->where('phone', 'LIKE', "%$value%");
                })
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } elseif ($param == 'name') {
            return $this
                ->model::select($columns)
                ->whereHas('client', function ($q) use ($value) {
                    $q->where('name', 'LIKE', "%$value%");
                })
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } elseif ($param == 'last_name') {
            return $this
                ->model::select($columns)
                ->whereHas('client', function ($q) use ($value) {
                    $q->where('last_name', 'LIKE', "%$value%");
                })
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } elseif ($param == 'waybill') {
            return $this
                ->model::select($columns)
                ->whereHas('client', function ($q) use ($value) {
                    $q->where('waybill', 'LIKE', "%$value%");
                })
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } elseif ($param == 'comment') {
            return $this
                ->model::select($columns)
                ->whereHas('client', function ($q) use ($value) {
                    $q->where('comment', 'LIKE', "%$value%");
                })
                ->orderBy('created_at', 'desc')
                ->with('client')
                ->paginate($perPage);
        } else {
            return $this
                ->model::select($columns)
                ->where('id', 'LIKE', "%$value%")
                ->orWhere(function ($query) use ($value) {
                    $query->where('waybill', 'LIKE', "%$value%")
                        ->where('comment', 'LIKE', "%$value%");
                })
                ->with('client')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        }

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

    public function countAllOrders($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)->where('manager_id', $manager_id)->count();
        } else {
            return $this->model::whereDate('created_at', $date)->count();
        }
    }

    public function countDoneOrders($date, $manager_id = null)
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

    public function countOrdersByStatus($status = null, $date = null, $manager_id = null)
    {
        if ($manager_id && $date && $status) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['status', $status],
                    ['manager_id', $manager_id],
                ])->count();
        } elseif ($manager_id && $date) {
            return $this->model::whereDate('created_at', $date)
                ->where('manager_id', $manager_id)->count();
        } elseif ($date && $status) {
            return $this->model::whereDate('created_at', $date)
                ->where('status', $status)->count();
        } elseif ($status && $manager_id) {
            return $this->model::where([
                ['status', $status],
                ['manager_id', $manager_id],
            ])->count();
        } elseif ($status) {
            return $this->model::where('status', $status)->count();
        } elseif ($date) {
            return $this->model::whereDate('created_at', $date)->count();
        } elseif ($manager_id) {
            return $this->model::whereDate('manager_id', $manager_id)->count();
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
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_PROCESSED);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_PREPAYMENT);
                    $query->orWhere('status', OrderStatus::STATUS_NEW);
                })
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_PROCESSED);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_PREPAYMENT);
                    $query->orWhere('status', OrderStatus::STATUS_NEW);
                })
                ->count();
        }
    }

    public function sumApprovalApplications($date, $manager_id = null)
    {
        if ($manager_id) {
            return $this->model::whereDate('created_at', $date)
                ->where('manager_id', $manager_id)
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_DONE);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_PREPAYMENT);
                    $query->orWhere('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER);
                    $query->orWhere('status', OrderStatus::STATUS_RETURN);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_DISPATCH);
                    $query->orWhere('status', OrderStatus::STATUS_ON_THE_ROAD);
                    $query->orWhere('status', OrderStatus::STATUS_AT_THE_POST_OFFICE);
                })
                ->count();
        } else {
            return $this->model::whereDate('created_at', $date)
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_DONE);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_PREPAYMENT);
                    $query->orWhere('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER);
                    $query->orWhere('status', OrderStatus::STATUS_RETURN);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_DISPATCH);
                    $query->orWhere('status', OrderStatus::STATUS_ON_THE_ROAD);
                    $query->orWhere('status', OrderStatus::STATUS_AT_THE_POST_OFFICE);
                })
                ->count();
        }
    }

    public function sumCountSalesOfAirMarginality($date = null, $manager_id = null)
    {
        if ($manager_id and $date) {
            return $this->model::whereDate('created_at', $date)
                ->where([
                    ['sale_of_air', 1],
                    ['manager_id', $manager_id]
                ])
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_DONE);
                    $query->orWhere('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER);
                    $query->orWhere('status', OrderStatus::STATUS_RETURN);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_DISPATCH);
                    $query->orWhere('status', OrderStatus::STATUS_ON_THE_ROAD);
                    $query->orWhere('status', OrderStatus::STATUS_AT_THE_POST_OFFICE);
                })
                ->count();
        } elseif ($date) {
            return $this->model::whereDate('created_at', $date)
                ->where('sale_of_air', 1)
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_DONE);
                    $query->orWhere('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER);
                    $query->orWhere('status', OrderStatus::STATUS_RETURN);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_DISPATCH);
                    $query->orWhere('status', OrderStatus::STATUS_ON_THE_ROAD);
                    $query->orWhere('status', OrderStatus::STATUS_AT_THE_POST_OFFICE);
                })
                ->count();
        } elseif ($manager_id) {
            return $this->model::where([
                ['sale_of_air', 1],
                ['manager_id', $manager_id]
            ])
                ->where(function ($query) {
                    $query->where('status', OrderStatus::STATUS_DONE);
                    $query->orWhere('status', OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER);
                    $query->orWhere('status', OrderStatus::STATUS_RETURN);
                    $query->orWhere('status', OrderStatus::STATUS_AWAITING_DISPATCH);
                    $query->orWhere('status', OrderStatus::STATUS_ON_THE_ROAD);
                    $query->orWhere('status', OrderStatus::STATUS_AT_THE_POST_OFFICE);
                })
                ->count();
        } else {
            return $this->model::where('sale_of_air', 1)
                ->count();
        }
    }

    public function sumPriceSalesOfAirMarginality($date = null, $manager_id = null)
    {
        if ($manager_id and $date) {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_DONE)
                ->where([
                    ['sale_of_air', 1],
                    ['manager_id', $manager_id]
                ])
                ->sum('sale_of_air_price');
        } elseif ($date) {
            return $this->model::whereDate('created_at', $date)
                ->where('status', OrderStatus::STATUS_DONE)
                ->where('sale_of_air', 1)
                ->sum('sale_of_air_price');
        } elseif ($manager_id) {
            return $this->model::where('status', OrderStatus::STATUS_DONE)
                ->where([
                    ['sale_of_air', 1],
                    ['manager_id', $manager_id]
                ])
                ->sum('sale_of_air_price');
        } else {
            return $this->model::where('sale_of_air', 1)
                ->where('status', OrderStatus::STATUS_DONE)
                ->sum('sale_of_air_price');
        }
    }

    public function sumDoneOrdersTotalPriceByDate($date)
    {
        return $this->model::whereDate('created_at', $date)
            ->select('status', 'total_price')
            ->where('status', OrderStatus::STATUS_DONE)
            ->sum('total_price');
    }

    public function averageCheckOfCompletedOrdersByDate($date)
    {
        return $this->model::whereDate('created_at', $date)
            ->select('status', 'total_price')
            ->where('status', OrderStatus::STATUS_DONE)
            ->average('total_price');
    }

    public function averageCountItemsCompletedOrdersByDate($date)
    {
        return $this->model::whereDate('created_at', $date)
            ->select('status', 'total_count')
            ->where('status', OrderStatus::STATUS_DONE)
            ->average('total_count');
    }
}
