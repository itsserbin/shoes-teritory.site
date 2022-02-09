<?php

namespace App\Http\Controllers\Admin\Api\Bookkeeping;

use App\Http\Controllers\Controller;
use App\Repositories\Bookkeeping\ProfitsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitsController extends Controller
{
    private $profitsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->profitsRepository = app(ProfitsRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->profitsRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->profitsRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->profitsRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
