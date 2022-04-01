<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\OptionsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OptionsController extends BaseController
{
    private $optionsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->optionsRepository = app(OptionsRepository::class);
    }

    public function getMainOptions(): JsonResponse
    {
        $result = $this->optionsRepository->getMainOptions();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function updateMainOptions(Request $request)
    {
        $result = $this->optionsRepository->updateMainOptions($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getScriptsOptions(): JsonResponse
    {
        $result = $this->optionsRepository->getScriptsOptions();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function updateScriptsOptions(Request $request)
    {
        $result = $this->optionsRepository->updateScriptsOptions($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
