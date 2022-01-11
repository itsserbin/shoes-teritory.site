<?php

namespace App\Http\Controllers\Public\Api;

use App\Repositories\Products\ProductColorsRepository;
use App\Repositories\Products\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductsController extends BaseController
{
    private $productRepository;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
    }

    /**
     * Get last products items.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->productRepository->getItemsWithPaginateOnProduction(15);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Show product item by ID
     *
     * @param $id
     * @return JsonResponse
     */
    public function getProduct($id): JsonResponse
    {
        $result = $this->productRepository->getById($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Show product colors by product ID.
     *
     * @param $id
     * @return JsonResponse
     */
    public function getProductColors($id): JsonResponse
    {
        $result = $this->productRepository->getProductColors($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getImages($id): JsonResponse
    {
        $result = $this->productRepository->getImages($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getReviews($id): JsonResponse
    {
        $result = $this->productRepository->getReviews($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getRelativeProducts($id): JsonResponse
    {
        $result = $this->productRepository->getRelativeProducts($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
