<?php

namespace App\Repositories;

use App\Models\Cart as Model;

/**
 * Class CartRepository
 * @package App\Repositories
 */
class CartRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function find($uuid)
    {
        return $this->model::where('hash', $uuid)->first();
    }

    public function create($uuid)
    {
        $cart = new $this->model;
        $cart->hash = $uuid;

        $cart->save();

        return $cart;
    }

    public function update($data, $uuid)
    {
        //
    }

    public function destroy($uuid)
    {
        return $this->model::where('hash', $uuid)->delete();
    }

    public function addPromoCode($cart_id, $code)
    {
        $model = $this->model::where('id', $cart_id)->first();
        $model->promo_code = $code;
        $model->save();

        return true;
    }

    public function deactivatePromoCode($cart_id)
    {
        return $this->model::where('id', $cart_id)->update(['promo_code' => null]);
    }
}
