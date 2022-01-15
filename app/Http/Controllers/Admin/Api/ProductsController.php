<?php

namespace App\Http\Controllers\Admin\Api;

use App\Repositories\Products\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    private $productsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productsRepository = app(ProductRepository::class);
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
            $result = $this->productsRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->productsRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->productsRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->productsRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->productsRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        return $this->returnResponse([
            'success' => true,
            'result' => $this->productsRepository->destroy($id),
        ]);
    }

    /**
     * @param $search
     * @return JsonResponse
     */
    public function search($search): JsonResponse
    {
        $result = $this->productsRepository->search($search);

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
        $result = $this->productsRepository->updateSort($id, $request->get('sort'));

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
        $result = $this->productsRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function attachColor($id, Request $request): JsonResponse
    {
        $result = $this->productsRepository->attachColor($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function detachColor($id, Request $request): JsonResponse
    {
        $result = $this->productsRepository->detachColor($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getProductColors($id): JsonResponse
    {
        $result = $this->productsRepository->getProductColors($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function list()
    {
        $result = $this->productsRepository->list();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
