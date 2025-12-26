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
        // $returnUpdate = OrderReturns::find($return);
        if ($action === 'refunded') {
            if ($return->order->payments) {
                $reference = $return->order->payments->reference;
                $data = $this->verifyPaystackTransaction($reference);
                // dd($data['reference'], $data['amount']);
                if ($data['status'] === "success") {
                    $refund = $this->refundPaystackTransaction($data['reference'], $data['amount']);
                    Mail::to($return->order->user->email)->send(new MailOrderReturns($return, $this->return->status));

                    $this->dispatch('refund-made', ['message' => "Order refund has been approved!"]);
                }
            }
        }
        // dd($returnUpdate->order->user->email);
        if ($return) {
            $return->update([
                'status' => $action
            ]);

            // Update the local return property
            $this->return->status = $action;
            // Optional: Show success message
            Mail::to($return->order->user->email)->send(new MailOrderReturns($return, $this->return->status));
            $this->dispatch('return-updated', [
                "message" => "Return {$action} successfully!"
            ]);
        }
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

            return false;
        }

        $payload = $response->json();

        // Paystack API-level success
        if (!($payload['status'] ?? false)) {
            return false;
        }

        // Transaction-level success
        if (($payload['data']['status'] ?? '') !== 'success') {
            return false;
        }

        return $payload['data']; // ✅ clean verified data
    }
    public function confirmPayment(string $reference)
    {

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");
        // dd([
        //     'reference' => $reference,
        //     'status' => $response->status(),
        //     'body' => $response->json(),
        // ]);
        if ($response->failed()) {
            dd([
                'reference' => $reference,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            return false;
        }

        $payload = $response->json();

        // Paystack API-level success
        if (!($payload['status'] ?? false)) {
            return false;
        }
        $payment_info = [
            "message" => $payload['message'],
            // "status" => $payload['data']['status'],
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
            dd([
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            logger()->error('Paystack refund failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \Exception('Refund request failed.');
        }

        $data = $response->json();

        if ($data['status'] !== true) {
            throw new \Exception($data['message'] ?? 'Refund not successful.');
        }

        return $data['data']['status'];
    }
    public function render()
    {
        return view('livewire.return-actions');
    }
}
