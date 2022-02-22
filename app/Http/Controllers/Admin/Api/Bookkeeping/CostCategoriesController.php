<?php

namespace App\Http\Controllers\Admin\Api\Bookkeeping;

use App\Http\Controllers\Controller;
use App\Repositories\Bookkeeping\CostCategoriesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CostCategoriesController extends Controller
{
    private $costCategoriesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->costCategoriesRepository = app(CostCategoriesRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->costCategoriesRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->costCategoriesRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->costCategoriesRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->costCategoriesRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->costCategoriesRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->costCategoriesRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function list(): JsonResponse
    {
        $result = $this->costCategoriesRepository->list();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
