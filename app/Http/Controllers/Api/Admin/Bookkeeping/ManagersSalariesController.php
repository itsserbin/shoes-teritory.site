<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->get('days')) {
            $result = $this->managersSalaryRepository->getAllStatisticsByTheNumberOfDays($request->get('days'));
        } elseif ($request->get('date_start') && $request->get('date_end') && $request->get('manager')) {
            $result = $this->managersSalaryRepository->getAllStatisticsByManagerAndDateRange($request->all());
        } elseif ($request->get('date_start') && $request->get('date_end')) {
            $result = $this->managersSalaryRepository->getAllStatisticsByDateRange($request->all());
        } elseif ($request->get('manager')) {
            $result = $this->managersSalaryRepository->getAllStatisticsByManager($request->get('manager'));
        } else {
            $result = $this->managersSalaryRepository->getAllStatistics();
        }

        return $this->returnResponse(['success' => true,
            'result' => $result,]);
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
