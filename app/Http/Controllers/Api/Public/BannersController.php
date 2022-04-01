<?php

namespace App\Http\Controllers\Api\Public;

use App\Repositories\BannersRepository;
use Illuminate\Http\JsonResponse;

class BannersController extends BaseController
{
    private $bannersRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bannersRepository = app(BannersRepository::class);
    }

    public function all(): JsonResponse
    {
        $result = $this->bannersRepository->getForPublic();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
