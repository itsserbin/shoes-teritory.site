<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\Products\ColorsRepository;
use Illuminate\Http\JsonResponse;

class ColorsController extends BaseController
{
    private $colorsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->colorsRepository = app(ColorsRepository::class);
    }

    public function list(): JsonResponse
    {
        $result = $this->colorsRepository->getList();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
