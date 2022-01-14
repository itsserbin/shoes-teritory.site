<?php

namespace App\Http\Controllers\Admin\Api;

use App\Repositories\OrdersRepository;
use App\Services\OrderCheckout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrdersController
 * @package App\Http\Controllers\Api
 */
class OrdersController extends BaseController
{
    /** @var OrdersRepository */
    private $ordersRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(OrdersRepository::class);
    }

    /**
     * Вывести все заказы в пагинацию по 15 шт.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->ordersRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->ordersRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $result = $this->ordersRepository->filter($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Поиск заказа в базе.
     *
     * @param $search
     * @return JsonResponse
     */
    public function search($search): JsonResponse
    {
        $result = $this->ordersRepository->search($search, 15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Удаление заказа.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->ordersRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить клиента по ID для редактирования.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $result = $this->ordersRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Обновление информации заказа по ID.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $result = $this->ordersRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function massActions(Request $request): JsonResponse
    {
        $result = $this->ordersRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
