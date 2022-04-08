<?php

namespace App\Http\Controllers\Api\Public;

use App\Repositories\ReviewsRepository;
use Illuminate\Http\JsonResponse;

class ReviewsController extends BaseController
{
    public $reviewsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->reviewsRepository = app(ReviewsRepository::class);
    }

    public function list(): JsonResponse
    {
        $result = $this->reviewsRepository->list(10);

        return $this->returnResponse([
            'success' => true,
            'result' => $result
        ]);
    }

    public function getProductReviews($id): JsonResponse
    {
        $result = $this->reviewsRepository->getProductReviews($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result
        ]);
    }
}
