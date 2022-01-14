<?php

namespace App\Repositories;

use App\Models\CartItems as Model;

class CartItemsRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function find($cart_id)
    {
        return $this->model::where('cart_id', $cart_id)->orderBy('created_at', 'asc')->get();
    }

    public function getItem($item_id, $cart_id)
    {
        return $this->model::where('cart_id', $cart_id)->where('product_id', $item_id)->first();
    }

    public function create($data, $cart_id)
    {
        $item = new $this->model;
        $item->cart_id = $cart_id;
        $item->product_id = $data['item_id'];
        $item->count = $data['count'];
        $item->size = $data['size'];
        $item->color = $data['color'];

        $item->save();

        return $item;
    }

    public function update($data, $cart_id)
    {
        $item = $this->model::where('cart_id', $cart_id)->where('product_id', $data['item_id'])->first();

        $item->count = $data['count'];

        $item->save();
    }

    public function destroy($cart_id, $id)
    {
        return $this->model::where('cart_id', $cart_id)->where('product_id', $id)->delete();
    }

    public function destroyCartItems($cart_id)
    {
        return $this->model::where('cart_id', $cart_id)->delete();
    }

    public function updateIncrement($cart_id, $id)
    {
        $model = $this->model::where('cart_id', $cart_id)->where('product_id', $id)->select('count')->first();

        return $this->model::where('cart_id', $cart_id)->where('product_id', $id)->update([
            'count' => $model->count + 1
        ]);
    }

    public function updateDecrement($cart_id, $id)
    {
        $model = $this->model::where('cart_id', $cart_id)->where('product_id', $id)->select('count')->first();

        if ($model->count !== 1) {
            return $this->model::where('cart_id', $cart_id)->where('product_id', $id)->update([
                'count' => $model->count - 1
            ]);
        } else {
            return false;
        }
    }
}
