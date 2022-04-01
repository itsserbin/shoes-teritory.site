<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\ClientsRepository;
use App\Repositories\OrdersRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class AdminController
 * @package App\Http\Controllers\Api
 */
class AdminController extends BaseController
{
    private $ClientsRepository;
    private $OrdersRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ClientsRepository = app(ClientsRepository::class);
        $this->OrdersRepository = app(OrdersRepository::class);
    }

    /**
     * @return JsonResponse
     */
    public function dashboard(): JsonResponse
    {
        $result = $this->ClientsRepository->getAllWithPaginate();
        $ordersToday = $this->OrdersRepository->countOrdersToday();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
            'ordersToday' => $ordersToday,
        ]);
    }
}
