<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

use App\Repositories\Bookkeeping\ProfitsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfitsController extends BaseController
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

        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $last = $request->get('last');

        if ($sort && $param) {
            $result = $this->profitsRepository->getAllWithPaginate(null, null, null, null, $sort, $param);
            $generalStat = $this->profitsRepository->generalStatistic();
            $chart = $this->profitsRepository->getDataForChart();
        } elseif ($date_start && $date_end) {
            $result = $this->profitsRepository->getAllWithPaginate($date_start, $date_end);
            $generalStat = $this->profitsRepository->generalStatistic($date_start, $date_end);
            $chart = $this->profitsRepository->getDataForChart($date_start, $date_end);
        } elseif ($last) {
            $result = $this->profitsRepository->getAllWithPaginate(null, null, $last);
            $generalStat = $this->profitsRepository->generalStatistic(null, null, $last);
            $chart = $this->profitsRepository->getDataForChart(null, null, $last);
        } else {
            $result = $this->profitsRepository->getAllWithPaginate();
            $generalStat = $this->profitsRepository->generalStatistic();
            $chart = $this->profitsRepository->getDataForChart();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
            'generalStat' => $generalStat,
            'chart' => $chart,
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
