<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\RolesRepository;
use Illuminate\Http\JsonResponse;

class RolesController extends BaseController
{
    private $rolesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->rolesRepository = app(RolesRepository::class);
    }

    public function list(): JsonResponse
    {
        $result = $this->rolesRepository->getAll();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
