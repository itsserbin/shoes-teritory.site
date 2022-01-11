<?php

namespace App\Http\Controllers\Public\Api;

use App\Http\Requests\OrderCreateRequest;
use App\Services\OrderCheckout;
use Illuminate\Http\JsonResponse;

class OrdersController extends BaseController
{
    private $orderCheckout;

    public function __construct(OrderCheckout $orderCheckout)
    {
        parent::__construct();
        $this->orderCheckout = $orderCheckout;
    }

    /**
     * Create order.
     *
     * @param OrderCreateRequest $orderCreateRequest
     * @return JsonResponse
     */
    public function create(OrderCreateRequest $orderCreateRequest): JsonResponse
    {
        $this->orderCheckout->createOrder($orderCreateRequest->all());

        return $this->returnResponse([
            'success' => true
        ]);

    }
}
