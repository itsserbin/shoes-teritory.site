<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

use App\Repositories\OrderItemsRepository;
use Illuminate\Http\JsonResponse;

class SupplierPaymentsController extends BaseController
{
    /** @var OrderItemsRepository */
    private $OrderItemsRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->OrderItemsRepository = app(OrderItemsRepository::class);
    }

    /**
     * Получить все заказы
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->OrderItemsRepository->allPayments(15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить все заказы, ожидающие выплаты от поставщика.
     *
     * @return JsonResponse
     */
    public function paymentsAwaiting(): JsonResponse
    {
        $result = $this->OrderItemsRepository->PaymentsAwaiting(15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить все заказы, с полученной выплатой.
     *
     * @return JsonResponse
     */
    public function paymentsReceived(): JsonResponse
    {
        $result = $this->OrderItemsRepository->paymentsReceived(15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
