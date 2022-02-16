<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Enum\ProductAvailability;
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
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })
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
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })
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
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })
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
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })
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
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbTopSwimwearAndTunics()
    {
        $products = Products::where('published', 1)
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })->where(function ($q) {
                $q->where('id', 119);
                $q->orWhere('id', 118);
                $q->orWhere('id', 116);
                $q->orWhere('id', 109);
                $q->orWhere('id', 103);
                $q->orWhere('id', 101);
                $q->orWhere('id', 104);
                $q->orWhere('id', 105);
                $q->orWhere('id', 98);
                $q->orWhere('id', 97);
                $q->orWhere('id', 96);
                $q->orWhere('id', 95);
                $q->orWhere('id', 80);
                $q->orWhere('id', 78);
                $q->orWhere('id', 74);
                $q->orWhere('id', 73);
                $q->orWhere('id', 70);
                $q->orWhere('id', 72);
                $q->orWhere('id', 71);
                $q->orWhere('id', 48);
                $q->orWhere('id', 39);
                $q->orWhere('id', 37);
                $q->orWhere('id', 29);
                $q->orWhere('id', 28);
                $q->orWhere('id', 25);
                $q->orWhere('id', 20);
                $q->orWhere('id', 12);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbTopSwimwear()
    {
        $products = Products::where('published', 1)
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })->where(function ($q) {
                $q->where('id', 66);
                $q->orWhere('id', 119);
                $q->orWhere('id', 118);
                $q->orWhere('id', 117);
                $q->orWhere('id', 115);
                $q->orWhere('id', 112);
                $q->orWhere('id', 111);
                $q->orWhere('id', 110);
                $q->orWhere('id', 109);
                $q->orWhere('id', 108);
                $q->orWhere('id', 107);
                $q->orWhere('id', 106);
                $q->orWhere('id', 97);
                $q->orWhere('id', 96);
                $q->orWhere('id', 95);
                $q->orWhere('id', 94);
                $q->orWhere('id', 93);
                $q->orWhere('id', 92);
                $q->orWhere('id', 91);
                $q->orWhere('id', 90);
                $q->orWhere('id', 83);
                $q->orWhere('id', 82);
                $q->orWhere('id', 78);
                $q->orWhere('id', 74);
                $q->orWhere('id', 43);
                $q->orWhere('id', 72);
                $q->orWhere('id', 71);
                $q->orWhere('id', 70);
                $q->orWhere('id', 64);
                $q->orWhere('id', 57);
                $q->orWhere('id', 43);
                $q->orWhere('id', 39);
                $q->orWhere('id', 37);
                $q->orWhere('id', 29);
                $q->orWhere('id', 25);
            });

        return response()->view('xml.fb-product-feed', [
            'products' => $products
        ])->header('Content-Type', 'application/xml');
    }

    public function xmlFbTopUnderwear()
    {
        $products = Products::where('published', 1)
            ->where(function ($query) {
                $query->where('status', ProductAvailability::IN_STOCK);
                $query->orWhere('status', ProductAvailability::ENDS);
            })->where(function ($q) {
                $q->where('id', 161);
                $q->orWhere('id', 159);
                $q->orWhere('id', 142);
                $q->orWhere('id', 139);
                $q->orWhere('id', 134);
                $q->orWhere('id', 131);
                $q->orWhere('id', 130);
                $q->orWhere('id', 125);
                $q->orWhere('id', 124);
                $q->orWhere('id', 121);
            });

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
