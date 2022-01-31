<?php

namespace App\Repositories;

use App\Models\Clients;
use App\Models\Clients as Model;
use App\Models\Enum\ClientStatus;
use App\Models\Enum\MassActions;
use App\Models\Products;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

class ClientsRepository extends CoreRepository
{

    private $promoCodesRepository;

    /**
     * ClientsController constructor.
     */
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
     * @return Model
     */
    public function getById($id)
    {
        return $this->startConditions()->with('orders')->find($id);
    }

    /**
     * Получить все продукты вывести в пагинации по 15 шт.
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
            'name',
            'last_name',
            'phone',
            'status',
            'sub_status',
            'number_of_purchases',
            'comment',
            'whole_check',
            'average_check',
            'created_at',
            'updated_at',
        ];

        return $this
            ->startConditions()
            ->select($columns)
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    /**
     * Искать в базе по критериям: ID, Имя и телефон.
     *
     * @param $request
     * @param null $perPage
     * @return mixed
     */
    public function search($search, $perPage = null)
    {
        $columns = [
            'id',
            'name',
            'last_name',
            'phone',
            'status',
            'sub_status',
            'number_of_purchases',
            'comment',
            'whole_check',
            'average_check',
            'created_at',
            'updated_at',
        ];

        return $this
            ->startConditions()
            ->select($columns)
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('last_name', 'LIKE', "%$search%")
            ->orWhere('phone', 'LIKE', "%$search%")
            ->orWhere('id', 'LIKE', "%$search%")
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
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
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'status' => $request['status'],
            'sub_status' => $request['sub_status'],
            'comment' => $request['comment'],
            'phone' => $request['phone'],
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
     * Проверить наличие клиента в БД.
     */
    public function checkByPhone($phone)
    {
        return $this->startConditions()->where('phone', $phone)->first();
    }

    /**
     * Записываем нового клиента в базу и создаем заказ.
     *
     * @param $name
     * @param $phone
     * @param $email
     * @param $last_name
     * @param $items
     * @param $promoCode
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createClient($name, $phone, $email, $last_name, $items, $promoCode)
    {
        $client = new Clients();
        $client->name = $name;
        $client->email = $email;
        $client->last_name = $last_name;
        $client->status = ClientStatus::NEW_STATUS;
        $client->phone = '+380' . $phone;
        $client->number_of_purchases = 1;

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

        $client->whole_check = $totalPrice;
        $client->purchased_goods = $totalCount;
        $client->average_check = $totalPrice / $totalCount;

        $client->save();

        return $client;
    }

    /**
     * Обновляем информацию о клиенте и создаем заказ.
     *
     * @param $client
     * @return mixed
     */
    public function updateClient($client, $items, $promoCode)
    {
        $result = $this->startConditions()->where('id', $client)->first();

        ++$result->number_of_purchases;
        $result->status = ClientStatus::EXPERIENCED_STATUS;

        $totalPrice = $result->whole_check;
        $totalCount = $result->purchased_goods;

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

        $result->whole_check = $totalPrice;
        $result->purchased_goods = $totalCount;
        $result->average_check = $totalPrice / $totalCount;


        $result->update();

        return $result;
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

    public function filter(array $data, int $perPage = 15)
    {
        $columns = [
            'id',
            'name',
            'last_name',
            'phone',
            'status',
            'sub_status',
            'number_of_purchases',
            'comment',
            'whole_check',
            'average_check',
            'created_at',
            'updated_at',
        ];

        return $this
            ->startConditions()
            ->where('status', $data['by'])
            ->select($columns)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function subFilter(array $data, int $perPage = 15)
    {
        $columns = [
            'id',
            'name',
            'last_name',
            'phone',
            'status',
            'sub_status',
            'number_of_purchases',
            'comment',
            'whole_check',
            'average_check',
            'created_at',
            'updated_at',
        ];

        return $this
            ->startConditions()
            ->where('sub_status', $data['by'])
            ->select($columns)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
