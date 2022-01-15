<?php

namespace App\Repositories;

use App\Models\CartItems;
use App\Models\OrderItems as Model;
use App\Repositories\Products\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderItemsRepository
 * @package App\Repositories
 */
class OrderItemsRepository extends CoreRepository
{
    private $promoCodesRepository;

    private $productRepository;

    private $ordersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->promoCodesRepository = app(PromoCodesRepository::class);
        $this->productRepository = app(ProductRepository::class);
        $this->ordersRepository = app(OrdersRepository::class);
    }

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $cartItems
     * @param $orderId
     * @return bool
     */
    public function create($cartItems, $orderId, $promoCode)
    {
//        $productRepository = new ProductRepository();

        foreach ($cartItems as $item) {
            $product = $this->productRepository->getById($item->product_id);

            $orderItem = new $this->model;
            $orderItem->order_id = $orderId;
            $orderItem->product_id = $product->id;
            $orderItem->count = $item->count;
            $orderItem->size = $item->size;
            $orderItem->color = $item->color;
            $orderItem->trade_price = $product->trade_price;
            $orderItem->sale_price = $product->discount_price ?: $product->price;
            $orderItem->profit = $orderItem->sale_price - $product->trade_price;
            $orderItem->total_price = $orderItem->sale_price * $orderItem->count;
            $orderItem->pay = false;
            $orderItem->provider_id = $product->Providers->id;

            if ($promoCode) {
                $discount = $this->promoCodesRepository->getDiscount($promoCode);

                if ($discount->discount_in_hryvnia) {
                    $orderItem->sale_price -= $discount->discount_in_hryvnia;
                } elseif ($discount->percent_discount) {
                    $orderItem->sale_price = $orderItem->sale_price * (100 - $discount->percent_discount) / 100;
                }
            }

            $orderItem->save();
        }

        return true;
    }

    /**
     * Получить элемент заказа по ID.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->startConditions()
            ->where('id', $id)
            ->first();
    }

    /**
     * Получить элемент заказа по ID заказа.
     *
     * @param $id
     * @return Builder[]|Collection
     */
    public function getByOrderId($id)
    {
        return $this->startConditions()
            ->with('product.providers')
            ->with('product.providers')
            ->where('order_id', $id)
            ->get();
    }

    /**
     * Удаление товара в заказе.
     *
     * @param $id
     * @return int
     */
    public function destroy($item_id, $order_id)
    {
        $model = $this->getById($item_id);
        $this->ordersRepository->updateOnDestroyOrderTotalPriceAndCount($order_id, $model->count, $model->sale_price);

        return $this->model::destroy($item_id);
    }

    /**
     * Вывести в пагинацию заказы, ожидающие выплаты от поставщика.
     *
     * @param null $perPage
     * @return mixed
     */
    public function PaymentsAwaiting($perPage = null)
    {
        return $this
            ->startConditions()
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where([
                        ['status', '=', 'Выполнен'],
                        ['order_items.pay', '=', false]
                    ]);
            })
            ->join('products', function ($join) {
                $join->on('order_items.product_id', '=', 'products.id');
            })
            ->join('providers', function ($join) {
                $join->on('order_items.provider_id', '=', 'providers.id');
            })
            ->select(
                'order_items.id',
                'order_items.order_id',
                'order_items.provider_id',
                'order_items.product_id',
                'order_items.pay',
                'order_items.profit',
                'products.h1 as product_h1',
                'providers.name as provider_name',
            )
            ->paginate($perPage);
    }

    public function paymentsReceived($perPage = null)
    {
        return $this
            ->startConditions()
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where([
                        ['status', '=', 'Выполнен'],
                        ['order_items.pay', '=', true]
                    ]);
            })
            ->join('products', function ($join) {
                $join->on('order_items.product_id', '=', 'products.id');
            })
            ->join('providers', function ($join) {
                $join->on('order_items.provider_id', '=', 'providers.id');
            })
            ->select(
                'order_items.id',
                'order_items.order_id',
                'order_items.provider_id',
                'order_items.product_id',
                'order_items.pay',
                'order_items.profit',
                'products.h1 as product_h1',
                'providers.name as provider_name',
            )
            ->paginate($perPage);
    }

    public function allPayments($perPage)
    {
        return $this
            ->startConditions()
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where([
                        ['status', '=', 'Выполнен'],
                    ]);
            })
            ->join('products', function ($join) {
                $join->on('order_items.product_id', '=', 'products.id');
            })
            ->join('providers', function ($join) {
                $join->on('order_items.provider_id', '=', 'providers.id');
            })
            ->select(
                'order_items.id',
                'order_items.order_id',
                'order_items.provider_id',
                'order_items.product_id',
                'order_items.pay',
                'order_items.profit',
                'products.h1 as product_h1',
                'providers.name as provider_name',
            )
            ->paginate($perPage);
    }

    /**
     * Обновить статус выплаты от поставщика.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updatePayStatus($id, $data)
    {
        return $this->model::where('id', $id)->update(['pay' => $data['pay']]);
    }

    /**
     * Обновить информацию о элементе заказа.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $model = $this->getById($id);
        $model->count = $data['count'];
        $model->size = json_encode($data['size']);
        $model->color = json_encode($data['color']);
        $model->total_price = $data['count'] * $model->sale_price;
        $model->update();

        return $model;

    }

    public function addItemToOrder($id, $data)
    {
        $product = $this->productRepository->getById($data['id']);

        $orderItem = new $this->model;
        $orderItem->order_id = $id;
        $orderItem->product_id = $product->id;
        $orderItem->count = $data['count'];
        $orderItem->size = $data['size'] ?? null;
        $orderItem->color = $data['color'] ?? null;
        $orderItem->pay = false;
        $orderItem->provider_id = $product->Providers->id;

        $orderItem->trade_price = $product->trade_price;
        $orderItem->sale_price = ($product->discount_price ?: $product->price);

        if (isset($data['resale'])) {
            $orderItem->resale = $data['resale'];
            $orderItem->discount = $data['discount'];
            $orderItem->total_price = ($product->discount_price ?: $product->price) * (int)$data['count'] - $data['discount'];


            $this->ordersRepository->updateOnAddOrderTotalPriceAndCount($id, $data['count'], $orderItem->total_price);
        } else {
            $orderItem->total_price = ($product->discount_price ?: $product->price) * (int)$data['count'];
            $this->ordersRepository->updateOnAddOrderTotalPriceAndCount($id, $data['count'], $orderItem->total_price);
        }
        $orderItem->profit = $orderItem->sale_price - $product->trade_price;

        $orderItem->save();

        return $orderItem;
    }
}
