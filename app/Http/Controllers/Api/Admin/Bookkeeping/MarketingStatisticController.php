<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

use App\Repositories\Bookkeeping\MarketingStatisticRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarketingStatisticController extends BaseController
{
    private $marketingStatisticRepository;

    public function __construct()
    {
        parent::__construct();
        $this->marketingStatisticRepository = app(MarketingStatisticRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $last = $request->get('last');

        if ($sort && $param) {
            $result = $this->marketingStatisticRepository->getAllWithPaginate(null, null, null, null, $sort, $param);
            $generalStat = $this->marketingStatisticRepository->generalStatistic();
            $chart = $this->marketingStatisticRepository->getDataForChart();
        } elseif ($date_start && $date_end) {
            $result = $this->marketingStatisticRepository->getAllWithPaginate($date_start, $date_end);
            $generalStat = $this->marketingStatisticRepository->generalStatistic($date_start, $date_end);
            $chart = $this->marketingStatisticRepository->getDataForChart($date_start, $date_end);
        } elseif ($last) {
            $result = $this->marketingStatisticRepository->getAllWithPaginate(null, null, $last);
            $generalStat = $this->marketingStatisticRepository->generalStatistic(null, null, $last);
            $chart = $this->marketingStatisticRepository->getDataForChart(null, null, $last);
        } else {
            $result = $this->marketingStatisticRepository->getAllWithPaginate();
            $generalStat = $this->marketingStatisticRepository->generalStatistic();
            $chart = $this->marketingStatisticRepository->getDataForChart();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
            'generalStat' => $generalStat,
            'chart' => $chart,
        ]);
    }
}
