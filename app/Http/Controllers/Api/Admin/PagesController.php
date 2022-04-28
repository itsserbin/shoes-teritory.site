<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\Pages\CreateRequest;
use App\Http\Requests\Admin\Pages\UpdateRequest;
use App\Repositories\PagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PagesController extends BaseController
{
    private $pagesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->pagesRepository = app(PagesRepository::class);
    }

    public function index(Request $request): JsonResponse
    {
        $sort = $request->get('sort');
        $param = $request->get('param');

        if ($sort && $param) {
            $result = $this->pagesRepository->getAllWithPaginate($sort, $param);
        } else {
            $result = $this->pagesRepository->getAllWithPaginate();
        }

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $result = $this->pagesRepository->create($request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function update($id, UpdateRequest $request): JsonResponse
    {
        $result = $this->pagesRepository->update($id, $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->pagesRepository->destroy($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function edit($id): JsonResponse
    {
        $result = $this->pagesRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function massActions(Request $request): JsonResponse
    {
        $result = $this->pagesRepository->massActions($request->get('action'), $request->all());

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
