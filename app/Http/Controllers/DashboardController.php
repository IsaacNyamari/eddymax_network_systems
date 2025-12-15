<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        }

        if ($user->hasRole('customer')) {
            return $this->customerDashboard();
        }

        return view('dashboard.index', ['user' => $user]);
    }

    public function admin()
    {
        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        // Basic Stats
        $stats = [
            'totalOrders' => Order::count(),
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

        // Calculate Average Order Value
        $completedOrdersCount = Order::where('status', 'delivered')->count();
        $stats['averageOrderValue'] = $completedOrdersCount > 0
            ? $stats['totalRevenue'] / $completedOrdersCount
            : 0;

        // Calculate AOV change (compared to previous period)
        $prevMonthRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->sum('total_amount');
        // return $prevMonthRevenue;
        $prevMonthOrders = Order::where('status', 'delivered')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->count();

        $prevMonthAOV = $prevMonthOrders > 0 ? $prevMonthRevenue / $prevMonthOrders : 0;
        $stats['aovChange'] = $prevMonthAOV > 0
            ? (($stats['averageOrderValue'] - $prevMonthAOV) / $prevMonthAOV) * 100
            : 0;

        // Conversion Rate (placeholder - you'd need analytics integration)
        $stats['conversionRate'] = 3.5; // Example value
        $stats['crChange'] = 0.5; // Example change

        // Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Top Products

        $topProducts = Order::select(
            'orders.id',
            'orders.order_number',
            'orders.total_amount',
            DB::raw('COUNT(payments.id) as payments_count')
        )
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.status', 'paid')
            ->groupBy(
                'orders.id',
                'orders.order_number',
                'orders.total_amount'
            )
            ->orderByDesc('orders.total_amount')
            ->limit(5)
            ->get();

        // return $topProducts;


        // Sales data for chart (last 30 days)
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent Activity
        $recentActivities = $this->getRecentActivities();

        return view('dashboard.admin.index', compact('stats', 'recentOrders', 'topProducts', 'salesData', 'recentActivities'));
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

    private function customerDashboard()
    {
        $user = Auth::user();

        // Total spent on paid orders
        $totalSpent = $user->orders()
            ->whereHas('payments', function ($query) {
                $query->where('status', 'paid'); // only count paid payments
            })
            ->sum('total_amount');

        // Aggregate stats for this customer
        $stats = [
            'totalOrders' => $user->orders()->count(),
            'pendingOrders' => $user->orders()->where('status', 'pending')->count(),
            'deliveredOrders' => $user->orders()->where('status', 'delivered')->count(),
            'shippedOrders' => $user->orders()->where('status', 'shipped')->count(),
            'completedOrders' => $user->orders()->where('status', 'completed')->count(),
            'totalSpent' => $totalSpent,
            'averageOrderValue' => $user->orders()->where('status', 'completed')->avg('total_amount') ?? 0,
        ];

        // Recent orders for this customer
        $recentOrders = $user->orders()
            ->with(['items', 'payments']) // eager load relationships
            ->orderBy('created_at', 'desc') // show newest first
            ->take(5)
            ->get();
        // return $user;
        return view('dashboard.customer.index', compact('stats', 'recentOrders'));
    }
}
