<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckPayment extends Controller
{

    public function checkMyBalance()
    {
        try {
            // Fetch the balance from Paystack
            $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
                ->get('https://api.paystack.co/balance');

            if ($response->failed()) {
                throw new \Exception('Unable to fetch Paystack balance.');
            }

            $data = $response->json();

            // return $data;

            if (!isset($data['data'])) {
                throw new \Exception('Invalid response from Paystack.');
            }

            // Filter KES balance (Kenyan Shillings)
            $kesBalance = collect($data['data'])->firstWhere('currency', 'KES');

            return [
                'status' => true,
                'balance' => $kesBalance['balance'] ?? 0, // amount in KES
                'available' => $kesBalance['available'] ?? 0, // available for refund/payout
            ];
        } catch (\Exception $e) {
            logger()->error('Paystack balance check failed', ['error' => $e->getMessage()]);
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'balance' => 0,
                'available' => 0,
            ];
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

        return $payload['data']['receipt_number']; // ✅ clean verified data
    }

    public function refundPaystackTransaction(string $reference, int $amountKes = null)
    {
        $payload = [
            'transaction' => $reference,
        ];

        // Convert KES to cents (Paystack expects lowest unit)
        if (!is_null($amountKes)) {
            $payload['amount'] = 50;
        }

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

        return $data['data'];
    }
}
