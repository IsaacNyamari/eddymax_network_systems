<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $activities = [];
        // KPIs
        $stats = [
            'totalOrders' => Order::count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'todayRevenue' => Order::where('status', 'delivered')
                ->whereDate('created_at', today())
                ->sum('total_amount'),
            'totalProducts' => Product::count(),
            // 'lowStockProducts' => Product::where('stock', '<', 10)->count(),
            // 'outOfStockProducts' => Product::where('stock', '<=', 0)->count(),
            'totalCustomers' => User::role('customer')->count(),
            'newCustomers' => User::role('customer')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->count(),
        ];
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent activities (your logic)
        $activities = $this->getRecentActivities();

        return view('dashboard.admin.reports.index', compact('stats', 'activities','salesData'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    private function getRecentActivities()
    {
        $activities = [];

        // Recent orders
        $recentOrders = Order::latest()->take(10)->paginate(10);
        foreach ($recentOrders as $order) {
            $activities[] = [
                'title' => 'New Order',
                'description' => "Order #{$order->order_number} from {$order->user->name}",
                'time' => $order->created_at->diffForHumans(),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
                'bgColor' => 'bg-blue-50',
                'textColor' => 'text-blue-600'
            ];
        }

        // New products
        $newProducts = Product::latest()->take(2)->get();
        foreach ($newProducts as $product) {
            $activities[] = [
                'title' => 'New Product Added',
                'description' => "{$product->name} added to catalog",
                'time' => $product->created_at->diffForHumans(),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>',
                'bgColor' => 'bg-green-50',
                'textColor' => 'text-green-600'
            ];
        }

        // New customers
        $newCustomers = User::role('customer')->latest()->take(2)->get();
        foreach ($newCustomers as $customer) {
            $activities[] = [
                'title' => 'New Customer',
                'description' => "{$customer->name} registered",
                'time' => $customer->created_at->diffForHumans(),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>',
                'bgColor' => 'bg-purple-50',
                'textColor' => 'text-purple-600'
            ];
        }

        // Sort by time
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
