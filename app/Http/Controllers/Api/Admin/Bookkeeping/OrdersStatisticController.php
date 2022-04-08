<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

use App\Repositories\Bookkeeping\OrdersStatisticsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdersStatisticController extends BaseController
{
    private $ordersStatisticsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ordersStatisticsRepository = app(OrdersStatisticsRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->get('last')) {
            $result = $this->ordersStatisticsRepository->getAllWithPaginate(null, null, $request->get('last'));
            $generalStatistics = $this->ordersStatisticsRepository->generalStatistic(null, null, $request->get('last'));
            $generalIndicatorsStatistic = $this->ordersStatisticsRepository->generalIndicatorsStatistic(null, null, $request->get('last'));
        } elseif ($request->get('date_start') && $request->get('date_end')) {
            $result = $this->ordersStatisticsRepository->getAllWithPaginate($request->get('date_start'), $request->get('date_end'));
            $generalStatistics = $this->ordersStatisticsRepository->generalStatistic($request->get('date_start'), $request->get('date_end'));
            $generalIndicatorsStatistic = $this->ordersStatisticsRepository->generalIndicatorsStatistic($request->get('date_start'), $request->get('date_end'));
        } else {
            $result = $this->ordersStatisticsRepository->getAllWithPaginate();
            $generalStatistics = $this->ordersStatisticsRepository->generalStatistic();
            $generalIndicatorsStatistic = $this->ordersStatisticsRepository->generalIndicatorsStatistic();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
            'generalStatistics' => $generalStatistics,
            'generalIndicatorsStatistic' => $generalIndicatorsStatistic
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
