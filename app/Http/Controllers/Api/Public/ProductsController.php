<?php

namespace App\Http\Controllers\Api\Public;

use App\Repositories\Products\ProductRepository;
use App\Services\ShoppingCart;
use Illuminate\Http\JsonResponse;

class ProductsController extends BaseController
{
    private $productRepository;
    private $shoppingCartService;

    /**
     * ClientsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
        $this->shoppingCartService = app(ShoppingCart::class);
    }

    /**
     * Get last products items.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->productRepository->getItemsWithPaginateOnProduction(8);

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
    public function getRelativeProducts($id): JsonResponse
    {
        $result = $this->productRepository->getRelativeProducts($id);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getBestSelling(): JsonResponse
    {
        $result = $this->productRepository->getBestSelling();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getWhereCategorySlug($slug): JsonResponse
    {
        $result = $this->productRepository->getWhereCategorySlugInProduction($slug, 12);

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getRecommendProducts(): JsonResponse
    {
        $result = $this->productRepository->getRecommendProducts();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getBestSellingProducts(): JsonResponse
    {
        $result = $this->productRepository->getBestSellingProducts();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function getNewProducts(): JsonResponse
    {
        $result = $this->productRepository->getNewProducts();

        return $this->returnResponse([
            'success' => true,
            'result' => $result,
        ]);
    }
}
