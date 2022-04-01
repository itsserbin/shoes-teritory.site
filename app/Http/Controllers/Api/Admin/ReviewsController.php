<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\ReviewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewsController extends BaseController
{
    private $reviewsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->reviewsRepository = app(ReviewsRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->reviewsRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->reviewsRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->reviewsRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->reviewsRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->reviewsRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $search
     * @return JsonResponse
     */
    public function search($search): JsonResponse
    {
        $result = $this->reviewsRepository->search($search);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateSort(int $id, Request $request): JsonResponse
    {
        $result = $this->reviewsRepository->updateSort($id, $request->get('sort'));

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function massActions(Request $request): JsonResponse
    {
        $result = $this->reviewsRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function accept($id): JsonResponse
    {
        $result = $this->reviewsRepository->accept($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
