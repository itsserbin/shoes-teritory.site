<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PromoCodesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodesController extends BaseController
{
    private $promoCodesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->promoCodesRepository = app(PromoCodesRepository::class);
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
            $result = $this->promoCodesRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->promoCodesRepository->getAllWithPaginate();
        }

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
        $result = $this->promoCodesRepository->search($search, 15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->promoCodesRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        $result = $this->promoCodesRepository->getById($id);

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
        $result = $this->promoCodesRepository->update($id, $request->all());

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
        $result = $this->promoCodesRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->promoCodesRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
