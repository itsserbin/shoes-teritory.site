<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderItemsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    private $orderItemsRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->orderItemsRepository = app(OrderItemsRepository::class);
    }

    public function getByOrderId($id): JsonResponse
    {
        $result = $this->orderItemsRepository->getByOrderId($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Удаление элемента заказа по ID.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($item_id,$order_id): JsonResponse
    {
        $result = $this->orderItemsRepository->destroy($item_id,$order_id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Обновить статус выплаты от поставщика
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePayStatus($id, Request $request): JsonResponse
    {
        $result = $this->orderItemsRepository->updatePayStatus($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить элемент заказа для редактирования.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $result = $this->orderItemsRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $result = $this->orderItemsRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function addItem($id, Request $request): JsonResponse
    {
        $result = $this->orderItemsRepository->addItemToOrder($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
