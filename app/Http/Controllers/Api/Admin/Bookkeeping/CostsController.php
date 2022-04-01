<?php

namespace App\Http\Controllers\Api\Admin\Bookkeeping;

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

        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $last = $request->get('last');

        if ($sort && $param) {
            $result = $this->costsRepository->getAllWithPaginate(null, null, null, null, $sort, $param);
            $generalStat = $this->costsRepository->generalStatistic();
            $all = $this->costsRepository->getAllForChart();
        } elseif ($date_start && $date_end) {
            $result = $this->costsRepository->getAllWithPaginate($date_start, $date_end);
            $generalStat = $this->costsRepository->generalStatistic($date_start, $date_end);
            $all = $this->costsRepository->getAllForChart($date_start, $date_end);
        } elseif ($last) {
            $result = $this->costsRepository->getAllWithPaginate(null, null, $last);
            $generalStat = $this->costsRepository->generalStatistic(null, null, $last);
            $all = $this->costsRepository->getAllForChart(null, null, $last);
        } else {
            $result = $this->costsRepository->getAllWithPaginate();
            $generalStat = $this->costsRepository->generalStatistic();
            $all = $this->costsRepository->getAllForChart();
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

    public function destroy($id): JsonResponse
    {
        $result = $this->costsRepository->destroy($id);

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
