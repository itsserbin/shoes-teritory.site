<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\Products\ColorsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function index(): JsonResponse
    {
        $result = $this->colorsRepository->getAllWithPaginate();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->colorsRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->colorsRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->colorsRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->colorsRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
