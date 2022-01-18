<?php

namespace App\Http\Controllers\Admin\Api\Bookkeeping;

use App\Http\Controllers\Admin\Api\BaseController;
use App\Repositories\Bookkeeping\ManagersSalaryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagersSalariesController extends BaseController
{

    private $managersSalaryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->managersSalaryRepository = app(ManagersSalaryRepository::class);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->managersSalaryRepository->getAllStatistics();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $result = $this->managersSalaryRepository->addDay($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
