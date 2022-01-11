<?php

namespace App\Http\Controllers\Public\Api;

use App\Services\ShoppingCart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    /** @var ShoppingCart */
    private $shoppingCart;

    public function __construct(ShoppingCart $shoppingCart)
    {
        parent::__construct();
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Get list cart items.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $result = $this->shoppingCart->cartList();

        return $this->returnResponse([
            'success' => true,
            'result' => $result
        ]);
    }

    /**
     * Add items to cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $uuid = $this->shoppingCart->addItem($request->all());

        if (!$uuid) {
            return $this->returnResponse([
                'success' => true,
            ]);
        } else {
            return $this->returnResponse([
                'success' => true,
            ], 201, [], ['name' => 'cart', 'value' => $uuid]);
        }
    }

    /**
     * Update product in cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $this->shoppingCart->updateCart($request->all());

        return $this->returnResponse([
            'success' => true,
        ]);
    }

    /**
     * Destroy cart item.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->shoppingCart->deleteItem($request->route('item'));

        return $this->returnResponse([
            'success' => true,
        ]);
    }
}
