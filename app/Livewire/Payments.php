<?php

namespace App\Livewire;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Payments extends Component
{
    use WithPagination;

    public $date = '30';
    public $status = '';
    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $query = Payment::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('order', function ($q) {
                        $q->where('order_number', 'like', '%' . $this->search . '%');
                    })->orWhere('amount', 'like', '%' . $this->search . '%')
                    ->orWhereHas('order.user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply date filter
        if ($this->date) {
            $days = (int) $this->date;

            // Calculate start date based on selection
            if ($days === 1) {
                // Last 24 hours
                $startDate = Carbon::now()->subHours(24);
            } else {
                // Last X days
                $startDate = Carbon::now()->subDays($days);
            }

            $query->where('created_at', '>=', $startDate);
        }

        $payments = $query->latest()->paginate(10);

        return view('livewire.payments', [
            'payments' => $payments
        ]);
    }

    // Reset pagination when filters change
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDate()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    // Export method
    public function export()
    {
        // Build query with all current filters
        $query = Payment::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('order.user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->date) {
            $days = (int) $this->date;
            if ($days === 1) {
                $startDate = Carbon::now()->subHours(24);
            } else {
                $startDate = Carbon::now()->subDays($days);
            }
            $query->where('created_at', '>=', $startDate);
        }

        $payments = $query->latest()->get();

        // Trigger download (you might want to use Laravel Excel package for better export)
        return response()->streamDownload(function () use ($payments) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, ['ID', 'Customer', 'Order Number', 'Amount', 'Status', 'Date']);

            // Add data rows
            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->id,
                    $payment->order->user->name ?? 'N/A',
                    $payment->order_number,
                    $payment->amount,
                    $payment->status,
                    $payment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        }, 'payments-' . now()->format('Y-m-d') . '.csv');
    }

    // Optional: Add query string for bookmarkable URLs
    protected $queryString = [
        'date' => ['except' => '30'],
        'status' => ['except' => ''],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];
}
