<?php

namespace App\Http\Controllers\Public;

use App\Http\Requests\ReviewCreateRequest;
use App\Models\Reviews;
use App\Repositories\AdvantagesRepository;
use App\Repositories\CategoriesRepository;
use App\Repositories\OptionsRepository;
use App\Repositories\PagesRepository;
use App\Repositories\Products\ProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class HomeController extends BaseController
{
    /** @var productRepository */
    private $productRepository;

    /** @var categoriesRepository */
    private $categoriesRepository;

    private $optionsRepository;

    private $advantagesRepository;

    private $pagesRepository;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(productRepository::class);
        $this->categoriesRepository = app(categoriesRepository::class);
        $this->optionsRepository = app(OptionsRepository::class);
        $this->advantagesRepository = app(AdvantagesRepository::class);
        $this->pagesRepository = app(PagesRepository::class);
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('pages.home.index', [
            'options' => $this->getOptions(),
            'products' => $this->productRepository->getItemsWithPaginateOnProduction(15),
            'advantages' => $this->getAdvantages(),
            'pages' => $this->getPagesList(),
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * @param $id
     * @return Factory|View|Application
     */
    public function product($id): Factory|View|Application
    {
        $this->productRepository->updateProductViewed($id);

        return view('pages.product.index', [
            'options' => $this->getOptions(),
            'product' => $this->productRepository->getProduct($id),
            'pages' => $this->getPagesList(),
            'advantages' => $this->getAdvantages(),
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function send_form_get()
    {
        return view('pages.order.index', [
            'options' => $this->getOptions(),
            'pages' => $this->getPagesList(),
            'categories' => $this->getCategories(),
        ]);
    }

    public function page($slug): Factory|View|Application
    {
        return view('pages.page', [
            'page' => $this->pagesRepository->getBySlug($slug),
            'options' => $this->getOptions(),
            'pages' => $this->getPagesList(),
            'categories' => $this->getCategories(),
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
            'pages' => $this->getPagesList(),
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * @return View|Factory|Application
     */
    public function cart(): View|Factory|Application
    {
        return view('pages.cart.index', [
            'options' => $this->getOptions(),
            'pages' => $this->getPagesList(),
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function category($slug): View|Factory|Application
    {
        $category = $this->categoriesRepository->findFySlug($slug);

        return view('pages.category.index', [
            'options' => $this->getOptions(),
            'pages' => $this->getPagesList(),
            'category' => $category,
            'categories' => $this->getCategories(),
        ]);
    }

    /**
     * Открыть карту сайта XML.
     *
     * @return Response
     */
    public function sitemap(): Response
    {
        $products = $this->productRepository->getAll();
        $categories = $this->categoriesRepository->getAllToFeed();

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
        $products = $this->productRepository->getAll();

        return response()->view('xml.images-sitemap', [
            'products' => $products,
        ])->header('Content-Type', 'application/xml');
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

    public function getPagesList()
    {
        return $this->pagesRepository->getPagesListToPublic();
    }

    public function getAdvantages()
    {
        return $this->advantagesRepository->getAllToPublic();
    }

    public function getCategories()
    {
        return $this->categoriesRepository->getAllOnProd();
    }
}
