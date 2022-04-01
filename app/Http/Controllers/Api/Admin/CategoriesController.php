<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\CategoriesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends BaseController
{
    /** @var CategoriesRepository */
    private $categoriesRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoriesRepository = app(CategoriesRepository::class);
    }

    /**
     * Показать все категории в пагинации.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->categoriesRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->categoriesRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить все категории.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $result = $this->categoriesRepository->getAll();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Создать новую категорию.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $result = $this->categoriesRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить категорию для редактирования.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $result = $this->categoriesRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Обновить информацию о категориях.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $result = $this->categoriesRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Удалить категорию.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->categoriesRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $search
     * @return JsonResponse
     */
    public function search($search): JsonResponse
    {
        $result = $this->categoriesRepository->search($search);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateSort(int $id, Request $request): JsonResponse
    {
        $result = $this->categoriesRepository->updateSort($id, $request->get('sort'));

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
        $result = $this->categoriesRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
