<?php

namespace App\Livewire;

use App\Mail\OrderReturns as MailOrderReturns;
use App\Models\OrderReturns;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ReturnActions extends Component
{
    public $return;
    public $return_status = 'pending';
    public function updateRequestStatus(OrderReturns $return, string $action)
    {
        if ($action === 'refunded') {
            if ($return->order->payments) {
                $reference = $return->order->payments->reference;
                $data = $this->verifyPaystackTransaction($reference);

                if ($data['status'] === "success") {
                    $refund_data = $this->refundPaystackTransaction($data['reference'], $data['amount']);
                    // ⬇️ CRITICAL FIX: Check if refund succeeded
                    if ($refund_data != 'processing') {
                        $this->dispatch('low-balance', $refund_data['message']);
                        return false; // Stop here if refund failed
                    }

                    // Only send email if refund succeeded
                    Mail::to($return->order->user->email)->send(new MailOrderReturns($return, $this->return->status));
                    $this->dispatch('refund-made', ['message' => "Order refund has been approved!"]);

                    // ⬇️ Update status only if refund succeeded
                    $return->update(['status' => $action]);
                    $this->return->status = $action;

                    return true; // Success
                } else if ($data['status'] === 'failed') {
                    $this->dispatch('verification-failed', ['message' => "Payment verification failed."]);

                    $this->dispatch('low-balance', "low balance!");

                    return false; // Stop here
                }
            } else {
                $this->dispatch('no-payment', ['message' => "No payment found for this order."]);
                return false; // Stop here
            }
        }

        // Handle non-refund actions
        if ($return) {
            $return->update(['status' => $action]);
            $this->return->status = $action;
            Mail::to($return->order->user->email)->send(new MailOrderReturns($return, $this->return->status));
            $this->dispatch('return-updated', [
                "message" => "Return {$action} successfully!"
            ]);
            return true;
        }

        return false;
    }
    public function verifyPaystackTransaction(string $reference)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->failed()) {
            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            $status = [
                'status' => 'failed'
            ];
            return $status;
        }

        $payload = $response->json();

        // Paystack API-level success
        if (!($payload['status'] ?? false)) {
            return false;
        }

        // Transaction-level success
        if (($payload['data']['status'] ?? '') !== 'success') {
            $status = [
                'status' => 'failed'
            ];
            return $status;
        }

        return $payload['data']; // ✅ clean verified data
    }
    public function confirmPayment(string $reference)
    {

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->failed()) {
            $this->dispatch();
            return false;
        }
        $payload = $response->json();

        // Paystack API-level success
        if (!($payload['status'] ?? false)) {
            return false;
        }

        $payment_info = [
            "status" => match ($payload['data']['status']) {
                'reversed' => 'refunded',
                'success' => 'paid',
                default => $payload['data']['status']
            },
            "message" => $payload['message'],
            "amount" => ($payload['data']['amount']) / 100,
            "receipt" => $payload['data']['receipt_number'],
            "brand" => $payload['data']['authorization']['brand'],
            "phone" => $payload['data']['authorization']['mobile_money_number']
        ];
        $payment_info = json_encode($payment_info, true);
        $this->dispatch('check-payment-success', [$payment_info]);
    }
    public function refundPaystackTransaction(string $reference, int $amountKes)
    {
        $payload = [
            'transaction' => $reference,
        ];

        // Convert KES to cents (Paystack expects lowest unit)
        // if (!is_null($amountKes)) {
        //     $payload['amount'] = 50;
        // }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post('https://api.paystack.co/refund', $payload);

        if ($response->failed()) {
            // $this->dispatch('low-balance', $response['message']);
            // throw new \Exception('Refund request failed.');
            return $response->json();
        }

        $data = $response->json();

        // if ($data['status'] !== true) {
        //     // $this->dispatch('low-balance', $response['message']);
        //     // throw new \Exception($data['message'] ?? 'Refund not successful.');
        //     return $response->json;
        // }

        return $data['data']['status'];
    }
    public function render()
    {
        return view('livewire.return-actions');
    }
}
