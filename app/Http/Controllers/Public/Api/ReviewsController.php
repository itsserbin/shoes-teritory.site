<?php

namespace App\Http\Controllers\Public\Api;

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
}
