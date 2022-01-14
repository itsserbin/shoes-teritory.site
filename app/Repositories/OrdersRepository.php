<?php

namespace App\Repositories;

use App\Models\Enum\MassActions;
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
            ->with('items.product.providers', 'client')
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
            ->startConditions()
            ->with('client')
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
            'waybill',
            'comment',
            'total_price',
            'total_count',
            'updated_at',
        ];

        return $this
            ->startConditions()
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
    public function create($city, $postalOffice, $client_id, $promoCode, $items)
    {
        $order = new $this->model;

        $order->city = $city;
        $order->postal_office = $postalOffice;
        $order->client_id = $client_id;
        $order->status = 'Новый';
        $order->promo_code = $promoCode;

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
     * @param $id
     * @param $request
     * @return mixed
     */
    public function update(int $id, array $request)
    {
        return $this->model::where('id', $id)->update([
            'status' => $request[0]['status'],
            'comment' => $request[0]['comment'],
            'city' => $request[0]['city'],
            'waybill' => $request[0]['waybill'],
            'postal_office' => $request[0]['postal_office'],
            'modified_by' => $request[1]['userName'],
        ]);


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
            ->with('product')
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
}
