<?php

namespace App\Http\Controllers\Api\Public;

use App\Repositories\FaqRepository;
use Illuminate\Http\JsonResponse;

class FaqController extends BaseController
{
    private $faqRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->faqRepository = app(FaqRepository::class);
    }

    public function list(): JsonResponse
    {
        $result = $this->faqRepository->getAllToPublic();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
