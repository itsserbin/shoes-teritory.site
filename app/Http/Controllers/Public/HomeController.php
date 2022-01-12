<?php

namespace App\Http\Controllers\Public;

use App\Http\Requests\ReviewCreateRequest;
use App\Models\Products;
use App\Models\ProductsPhoto;
use App\Models\Reviews;
use App\Models\Options;
use App\Repositories\CategoriesRepository;
use App\Repositories\OptionsRepository;
use App\Repositories\Products\ProductRepository;
use App\Services\OrderCheckout;
use App\Services\ShoppingCart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends BaseController
{
    /** @var ProductRepository */
    private $ProductRepository;

    /** @var OrderCheckout */
    private $OrderCheckout;

    /** @var ShoppingCart */
    private $ShoppingCart;

    /** @var CategoriesRepository */
    private $CategoriesRepository;
    private $optionsRepository;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(
        OrderCheckout $orderCheckout,
        ShoppingCart  $shoppingCart

    )
    {
        parent::__construct();
        $this->ProductRepository = app(ProductRepository::class);
        $this->CategoriesRepository = app(CategoriesRepository::class);
        $this->optionsRepository = app(OptionsRepository::class);
        $this->OrderCheckout = $orderCheckout;
        $this->ShoppingCart = $shoppingCart;
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('pages.home.index', [
            'options' => $this->getOptions(),
            'products' => $this->ProductRepository->getItemsWithPaginateOnProduction(15),
        ]);
    }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function product($id): Factory|View|Application
    {
        $product = $this->ProductRepository->getProduct($id);

        return view('pages.product.index', [
            'options' => $this->getOptions(),
            'product' => $product,
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function send_form_get()
    {
        return view('pages.order.index', [
            'options' => $this->getOptions(),
        ]);
    }

    public function send_review_post(ReviewCreateRequest $reviewCreateRequest)
    {
        $reviews = new Reviews();
        $data = $reviewCreateRequest->all();
        $reviews->create($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function checkout(): View|Factory|Application
    {
        return view('pages.checkout.index', [
            'options' => $this->getOptions(),
        ]);
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function category($slug): View|Factory|Application
    {
        $category = $this->CategoriesRepository->findFySlug($slug);

        return view('pages.category.index', [
            'options' => $this->getOptions(),
            'category' => $category
        ]);
    }

    /**
     * Открыть карту сайта XML.
     *
     * @return Response
     */
    public function sitemap(): Response
    {
        $products = $this->ProductRepository->getAll();
        $categories = $this->CategoriesRepository->getAllToFeed();

        return response()->view('xml.sitemap', [
            'products' => $products,
            'categories' => $categories,
        ])->header('Content-Type', 'application/xml');
    }

    /**
     * Открыть карту изображений XML.
     *
     * @return Response
     */
    public function imagesSitemap(): Response
    {
        $products = $this->ProductRepository->getAll();

        return response()->view('xml.images-sitemap', [
            'products' => $products,
        ])->header('Content-Type', 'application/xml');
    }

    /**
     * Открыть политику конфеденциальности
     */
    public function privacyPolicy(): Factory|View|Application
    {
        return view('pages.privacy-policy', [
            'options' => $this->getOptions(),
        ]);
    }

    /**
     * Открыть политику обмена и возврата.
     *
     * @return Application|Factory|View
     */
    public function exchangePolicy(): View|Factory|Application
    {
        return view('pages.exchange-policy', [
            'options' => $this->getOptions(),
        ]);
    }

    /**
     * Открыть robots.txt
     *
     * @return Response
     */
    public function robots(): Response
    {
        return response()->view('robots')->header('Content-Type', 'text/plain');
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->optionsRepository->getToProd();
    }
}
