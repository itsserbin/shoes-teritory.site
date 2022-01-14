<?php

namespace App\Http\Controllers\Admin\Api;

use App\Repositories\ClientsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends BaseController
{
    /** @var ClientsRepository */
    private $clientsRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->clientsRepository = app(ClientsRepository::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->clientsRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->clientsRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Поиск по клиентской базе.
     *
     * @param $search
     * @return JsonResponse
     */
    public function search($search): JsonResponse
    {
        $result = $this->clientsRepository->search($search, 15);

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
        $result = $this->clientsRepository->filter($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function subFilter(Request $request): JsonResponse
    {
        $result = $this->clientsRepository->subFilter($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Удаление клиента.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->clientsRepository->destroy($id);

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
        $result = $this->clientsRepository->getById($id);

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
        $result = $this->clientsRepository->update($id, $request->all());

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
        $result = $this->clientsRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
