<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\PdfReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardReportExport;

class ReportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfReportService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of the resource.
     */
    public $statistics = [];

    public function index()
    {
        $activities = [];
        // KPIs
        $stats = $this->getStats();
        $this->statistics = $stats;

        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent activities
        $activities = $this->getRecentActivities();
        $topProducts = Product::select([
            'products.id',
            'products.name',
            'products.price',
            'products.image',
            'products.category_id',
            'products.stock_quantity',
            DB::raw('COUNT(order_items.id) as orders_count'),
            DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
            DB::raw('SUM(order_items.quantity) as total_sold') // Added for completeness
        ])
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image', 'products.category_id', 'products.stock_quantity')
            ->having('orders_count', '>', 0) // Only products with orders
            ->with('category')
            ->orderByDesc('revenue')
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get();

        // Order status distribution
        $orderStatusDistribution = Order::select(
            'status',
            DB::raw('COUNT(*) as count'),
            DB::raw('ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM orders), 1) as percentage')
        )
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return view('dashboard.admin.reports.index', compact('stats', 'activities', 'salesData', 'topProducts', 'orderStatusDistribution'));
    }

    /**
     * Print PDF report
     */
    public function print()
    {
        $stats = $this->getStats();

        // Method 1: Using Service
        $pdf = $this->pdfService->generateDashboardReport($stats);
        return $pdf->download('dashboard-report-' . date('Y-m-d') . '.pdf');

        // Method 2: Direct in controller (alternative)
        // return $this->generatePdf($stats);
    }

    /**
     * Export Excel report
     */
    public function excel()
    {
        $stats = $this->getStats();
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = Product::select([
            'products.id',
            'products.name',
            'products.price',
            DB::raw('COUNT(order_items.id) as orders_count'),
            DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
            DB::raw('SUM(order_items.quantity) as total_sold')
        ])
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->having('orders_count', '>', 0)
            ->orderByDesc('revenue')
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();

        $orderStatusDistribution = Order::select(
            'status',
            DB::raw('COUNT(*) as count'),
            DB::raw('ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM orders), 1) as percentage')
        )
            ->groupBy('status')
            ->get();

        // FIX: Load relationships properly
        $recentOrders = Order::with(['user', 'orderItems'])->latest()->take(20)->get();

        $reportData = [
            'stats' => $stats,
            'salesData' => $salesData,
            'topProducts' => $topProducts,
            'orderStatusDistribution' => $orderStatusDistribution,
            'recentOrders' => $recentOrders,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ];

        $filename = 'dashboard-report-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new DashboardReportExport($reportData), $filename);
    }

    /**
     * Generate PDF directly (alternative method)
     */
    private function generatePdf($stats)
    {
        // Get logo path
        $logoPath = public_path('storage/logo.png'); // Adjust path as needed
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('pdf.dashboard-report', [
            'data' => $stats,
            'logo' => $logoBase64
        ]);

        return $pdf->download('dashboard-report-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Get statistics data
     */
    private function getStats()
    {
        return [
            'totalOrders' => Order::count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'shippedOrders' => Order::where('status', 'shipped')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'todayRevenue' => Order::where('status', 'delivered')
                ->whereDate('created_at', today())
                ->sum('total_amount'),
            'totalProducts' => Product::count(),
            'lowStockProducts' => Product::where('stock_quantity', '<', 10)->count(),
            'outOfStockProducts' => Product::where('stock_status', 'out_of_stock')->count(),
            'totalCustomers' => User::role('customer')->count(),
            'newCustomers' => User::role('customer')
                ->whereDate('created_at', '>=', now()->subMonth())
                ->count(),
        ];
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
}
