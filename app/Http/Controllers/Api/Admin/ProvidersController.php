<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\Bookkeeping\ProvidersRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function index(): JsonResponse
    {
        $result = $this->providersRepository->getAllWithPaginate();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $result = $this->providersRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->providersRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, Request $request): JsonResponse
    {
        $result = $this->providersRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }


    public function destroy($id): JsonResponse
    {
        $result = $this->providersRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

}
