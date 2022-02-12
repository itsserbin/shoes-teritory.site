<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Repositories\CategoriesRepository;
use App\Repositories\Products\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class XmlController extends Controller
{
    private $productRepository;
    private $categoriesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
        $this->categoriesRepository = app(CategoriesRepository::class);
    }

    public function xmlFbAll()
    {
        $products = Products::where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbUnderwear()
    {
        $products = Products::whereHas('categories', function ($q) {
            $q->where('id', 7);
        })
            ->where([
                ['published', 1],
                ['id', '!=', 139],
                ['id', '!=', 137],
                ['id', '!=', 124],
                ['id', '!=', 126],
                ['id', '!=', 134],
                ['id', '!=', 141],
                ['id', '!=', 133],
                ['id', '!=', 127],
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbSwimwearAndTunics()
    {
        $products = Products::whereHas('categories', function ($q) {
            $q->where('id', 6);
            $q->orWhere('id', 5);
            $q->orWhere('id', 3);
        })
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbSwimwearAndTunics5Xl()
    {
        $products = Products::whereHas('categories', function ($q) {
            $q->where('id', '!=', 7);
        })
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbBigSize()
    {
        $products = Products::whereHas('categories', function ($q) {
            $q->where('id', 8);
        })
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbTopSwimwearAndTunics()
    {
        $products = Products::where('id', 119)
            ->orWhere('id', 118)
            ->orWhere('id', 116)
            ->orWhere('id', 109)
            ->orWhere('id', 103)
            ->orWhere('id', 101)
            ->orWhere('id', 104)
            ->orWhere('id', 105)
            ->orWhere('id', 98)
            ->orWhere('id', 97)
            ->orWhere('id', 96)
            ->orWhere('id', 95)
            ->orWhere('id', 80)
            ->orWhere('id', 78)
            ->orWhere('id', 74)
            ->orWhere('id', 73)
            ->orWhere('id', 70)
            ->orWhere('id', 72)
            ->orWhere('id', 71)
            ->orWhere('id', 48)
            ->orWhere('id', 39)
            ->orWhere('id', 37)
            ->orWhere('id', 29)
            ->orWhere('id', 28)
            ->orWhere('id', 25)
            ->orWhere('id', 20)
            ->orWhere('id', 12)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    /**
     * Открыть товарный фид для prom.ua.
     *
     * @return Response
     */
    public function promProductFeed(): Response
    {
        $products = $this->productRepository->getAll();
        $categories = $this->categoriesRepository->getAllToFeed();

        return response()->view('xml.prom-product-feed', [
            'products' => $products,
            'categories' => $categories,
        ])->header('Content-Type', 'application/xml');
    }
}
