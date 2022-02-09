<?php

namespace App\Http\Controllers\Admin\Api\Bookkeeping;

use App\Http\Controllers\Admin\Api\BaseController;
use App\Repositories\Bookkeeping\CostsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CostsController extends BaseController
{
    private $costsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->costsRepository = app(CostsRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->costsRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->costsRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->costsRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->costsRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->costsRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
