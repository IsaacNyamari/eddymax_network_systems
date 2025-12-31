<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;

class DashboardReportExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new DashboardSummarySheet($this->data),
            new SalesDataSheet($this->data),
            new TopProductsSheet($this->data),
            new OrderStatusSheet($this->data),
            new RecentOrdersSheet($this->data),
        ];

        return $sheets;
    }
}

class DashboardSummarySheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function headings(): array
    {
        return [
            ['Dashboard Report - Generated on ' . $this->data['generated_at']],
            [],
            ['Key Performance Indicators'],
            ['Metric', 'Value', 'Details']
        ];
    }

    public function collection()
    {
        $stats = $this->data['stats'];
        
        $data = [
            ['Total Orders', $stats['totalOrders'], 'All orders placed'],
            ['Total Revenue', 'KES ' . number_format($stats['totalRevenue'], 2), 'From delivered orders'],
            ['Pending Orders', $stats['pendingOrders'], 'Orders awaiting processing'],
            ['Processing Orders', $stats['processingOrders'], 'Orders being prepared'],
            ['Delivered Orders', $stats['deliveredOrders'], 'Successfully delivered orders'],
            ['Shipped Orders', $stats['shippedOrders'] ?? 0, 'Orders in transit'],
            ['Cancelled Orders', $stats['cancelledOrders'] ?? 0, 'Cancelled orders'],
            ['Today\'s Orders', $stats['todayOrders'], 'Orders placed today'],
            ['Today\'s Revenue', 'KES ' . number_format($stats['todayRevenue'], 2), 'Revenue from today'],
            ['Total Products', $stats['totalProducts'], 'Products in catalog'],
            ['Low Stock Products', $stats['lowStockProducts'], 'Products with < 10 units'],
            ['Out of Stock Products', $stats['outOfStockProducts'], 'Products with 0 units'],
            ['Total Customers', $stats['totalCustomers'], 'Registered customers'],
            ['New Customers (Last 30 days)', $stats['newCustomers'], 'Recently registered'],
        ];

        return collect($data);
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(40);

        // Style the title row
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFE0E0E0']
            ],
        ]);

        $sheet->getStyle('A4:C4')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF0F0F0']
            ],
            'borders' => [
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Add borders to data rows
        $dataCount = count($this->collection());
        $lastRow = 4 + $dataCount;
        $dataRange = 'A4:C' . $lastRow;
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);
    }
}

class SalesDataSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Sales Data';
    }

    public function headings(): array
    {
        return [
            ['Sales Data - Last 30 Days'],
            [],
            ['Date', 'Daily Sales (KES)', 'Cumulative Sales (KES)']
        ];
    }

    public function collection()
    {
        $salesData = $this->data['salesData'];
        $cumulative = 0;
        
        $formattedData = $salesData->map(function ($item) use (&$cumulative) {
            $cumulative += $item->total;
            return [
                'date' => $item->date,
                'daily_sales' => $item->total,
                'cumulative_sales' => $cumulative,
            ];
        });

        return $formattedData;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);

        // Title
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFE0F0FF']
            ],
        ]);

        // Headers
        $sheet->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFE8F4FF']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Format numbers as currency
        $dataCount = count($this->collection());
        $lastRow = 3 + $dataCount;
        $range = 'B4:C' . $lastRow;
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode('#,##0.00');
    }
}

class TopProductsSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Top Products';
    }

    public function headings(): array
    {
        return [
            ['Top Performing Products'],
            [],
            ['Rank', 'Product Name', 'Price (KES)', 'Units Sold', 'Total Orders', 'Revenue (KES)']
        ];
    }

    public function collection()
    {
        $products = $this->data['topProducts'];
        
        return $products->map(function ($product, $index) {
            return [
                'rank' => $index + 1,
                'name' => $product->name,
                'price' => $product->price,
                'units_sold' => $product->total_sold ?? 0,
                'orders_count' => $product->orders_count ?? 0,
                'revenue' => $product->revenue ?? 0,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(20);

        // Title
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF0FFE0']
            ],
        ]);

        // Headers
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF0FFF0']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Format currency columns
        $dataCount = count($this->collection());
        $lastRow = 3 + $dataCount;
        $sheet->getStyle('C4:C' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F4:F' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
    }
}

class OrderStatusSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Order Status';
    }

    public function headings(): array
    {
        return [
            ['Order Status Distribution'],
            [],
            ['Status', 'Count', 'Percentage (%)']
        ];
    }

    public function collection()
    {
        $statusData = $this->data['orderStatusDistribution'];
        
        return $statusData->map(function ($item) {
            return [
                'status' => ucfirst($item->status),
                'count' => $item->count,
                'percentage' => $item->percentage,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);

        // Title
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFF0E0']
            ],
        ]);

        // Headers
        $sheet->getStyle('A3:C3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFF8F0']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);
    }
}

class RecentOrdersSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Recent Orders';
    }

    public function headings(): array
    {
        return [
            ['Recent Orders'],
            [],
            ['Order Number', 'Customer', 'Date', 'Status', 'Amount (KES)', 'Items']
        ];
    }

    public function collection()
    {
        $orders = $this->data['recentOrders'];
        
        return $orders->map(function ($order) {
            // Safely get order items count
            $itemsCount = 0;
            
            if ($order->relationLoaded('orderItems') && $order->orderItems) {
                $itemsCount = $order->orderItems->sum('quantity');
            } elseif (method_exists($order, 'orderItems')) {
                // Try to load it if not loaded
                $itemsCount = $order->orderItems()->sum('quantity');
            }
            
            return [
                'order_number' => $order->order_number,
                'customer' => $order->user ? $order->user->name : 'N/A',
                'date' => $order->created_at->format('Y-m-d'),
                'status' => ucfirst($order->status),
                'amount' => $order->total_amount,
                'items' => $itemsCount,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(10);

        // Title
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFF0F0FF']
            ],
        ]);

        // Headers
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFE8E8FF']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Format date and currency
        $dataCount = count($this->collection());
        $lastRow = 3 + $dataCount;
        $sheet->getStyle('C4:C' . $lastRow)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet->getStyle('E4:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
    }
}