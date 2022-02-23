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

        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $last = $request->get('last');

        if ($sort && $param) {
            $result = $this->profitsRepository->getAllWithPaginate(null, null, null, null, $sort, $param);
            $generalStat = $this->profitsRepository->generalStatistic();
            $all = $this->profitsRepository->getAll();
        } elseif ($date_start && $date_end) {
            $result = $this->profitsRepository->getAllWithPaginate($date_start, $date_end);
            $generalStat = $this->profitsRepository->generalStatistic($date_start, $date_end);
            $all = $this->profitsRepository->getAll($date_start, $date_end);
        } elseif ($last) {
            $result = $this->profitsRepository->getAllWithPaginate(null, null, $last);
            $generalStat = $this->profitsRepository->generalStatistic(null, null, $last);
            $all = $this->profitsRepository->getAll(null, null, $last);
        } else {
            $result = $this->profitsRepository->getAllWithPaginate();
            $generalStat = $this->profitsRepository->generalStatistic();
            $all = $this->profitsRepository->getAll();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
            'generalStat' => $generalStat,
            'all' => $all,
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
