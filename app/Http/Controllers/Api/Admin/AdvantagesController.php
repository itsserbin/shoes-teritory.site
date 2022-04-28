<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\AdvantagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvantagesController extends BaseController
{
    private $advantagesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->advantagesRepository = app(AdvantagesRepository::class);
    }

    public function index(): JsonResponse
    {
        $result = $this->advantagesRepository->getAllWithPaginate();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->advantagesRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->advantagesRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->advantagesRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->advantagesRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
