<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    /**
     * Main sitemap index
     */
    public function index()
    {
        // Calculate product sitemaps needed
        $productCount = Product::whereNull('deleted_at')->count();
        $sitemapCount = ceil($productCount / 50000);
        
        $sitemaps = [];
        
        // Static pages sitemap
        $sitemaps[] = [
            'loc' => url('/sitemap-static.xml'),
            'lastmod' => Carbon::now()->format('Y-m-d')
        ];
        
        // Product sitemaps
        if ($sitemapCount > 0) {
            for ($i = 0; $i < $sitemapCount; $i++) {
                $sitemaps[] = [
                    'loc' => url("/sitemap-products-{$i}.xml"),
                    'lastmod' => Carbon::now()->format('Y-m-d')
                ];
            }
        }
        
        return response()->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Static pages sitemap
     */
    public function staticPages()
    {
        $pages = [
            [
                'loc' => route('store.home'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'always',
                'priority' => '1.0'
            ],
            [
                'loc' => route('store.shop'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'always',
                'priority' => '0.9'
            ],
            [
                'loc' => route('store.contact'),
                'lastmod' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => route('pages.return-refund'),
                'lastmod' => Carbon::now()->subDays(180)->format('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.5'
            ],
            // [
            //     'loc' => route('store.cart'),
            //     'lastmod' => Carbon::now()->subDays(7)->format('Y-m-d'),
            //     'changefreq' => 'weekly',
            //     'priority' => '0.3'
            // ],
            // [
            //     'loc' => route('store.checkout'),
            //     'lastmod' => Carbon::now()->subDays(7)->format('Y-m-d'),
            //     'changefreq' => 'weekly',
            //     'priority' => '0.3'
            // ]
        ];
        
        // Add login/register if routes exist
        if (Route::has('login')) {
            $pages[] = [
                'loc' => route('login'),
                'lastmod' => Carbon::now()->subDays(90)->format('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.1'
            ];
        }
        
        if (Route::has('register')) {
            $pages[] = [
                'loc' => route('register'),
                'lastmod' => Carbon::now()->subDays(90)->format('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.1'
            ];
        }
        
        return response()->view('sitemap.static', compact('pages'))
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Product sitemaps
     */
    public function products($page = 0)
    {
        $perPage = 50000;
        $offset = $page * $perPage;
        
        // Get non-deleted products
        $products = Product::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->skip($offset)
            ->take($perPage)
            ->get(['id', 'slug', 'name', 'updated_at', 'image', 'stock_status']);
        
        // Return 404 if no products found (and not page 0)
        if ($products->isEmpty() && $page > 0) {
            abort(404);
        }
        
        return response()->view('sitemap.products', compact('products'))
            ->header('Content-Type', 'application/xml');
    }
}