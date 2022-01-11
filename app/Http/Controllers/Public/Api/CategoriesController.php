<?php

namespace App\Http\Controllers\Public\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    /** @var CategoriesRepository */
    private $categoriesRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoriesRepository = app(CategoriesRepository::class);
    }

    /**
     * Получить категорию по Slug для вывода на продакшн.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function getBySlug($slug): JsonResponse
    {
        $result = $this->categoriesRepository->getCategoryOnProduction($slug);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить товары из категории по Slug для вывода на продакшн.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function getCategoryProducts($slug): JsonResponse
    {
        $result = $this->categoriesRepository->getCategoryProductsOnProduction($slug, 15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Получить категории для вывода на прод.
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $result = $this->categoriesRepository->getAllOnProd();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
