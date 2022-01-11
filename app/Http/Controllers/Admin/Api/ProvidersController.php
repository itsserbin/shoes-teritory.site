<?php

namespace App\Http\Controllers\Admin\Api;

use App\Repositories\Bookkeeping\ProvidersRepository;
use Illuminate\Http\JsonResponse;

class ProvidersController extends BaseController
{
    private $providersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->providersRepository = app(ProvidersRepository::class);
    }

    public function list(): JsonResponse
    {
        $result = $this->providersRepository->list();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
