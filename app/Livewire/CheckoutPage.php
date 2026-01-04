<?php

namespace App\Livewire;

use App\Models\Counties;
use App\Models\User;
use App\Models\Address;
use App\Models\Adresses;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\PaymentStatus;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;


//random password trait
class RandomPassword
{
    public function generate($length = 8)
    {
        $password = Str::random($length);
        return $password;
    }
}
class CheckoutPage extends Component
{
    public $cart = [];
    public $total = 0;
    public $counties;
    public $selectedCounty;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $city;
    protected $smsService;

    public  $randomPassword = "";
    public $createAccount = false;
    public $password;

    protected $listeners = [
        'payment-successful' => 'paymentSuccessful',
        'payment-failed' => 'paymentFailed'
    ];

    // Store order reference temporarily between payment initiation and completion
    public $temporaryOrderReference = null;

    public function boot()
    {
        // Initialize SMS service using dependency injection
        $this->smsService = app(SmsService::class);
    }

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
        $this->counties = Counties::all();
        $randPass = new RandomPassword();
        $this->randomPassword = $randPass->generate();
        if ($user = Auth::user()) {
            $this->name = $user->name;
            $this->email = $user->email;
            $address = $user->addresses->first();
            $this->phone = $address->phone ?? '';
            $this->address = $address->address ?? '';
            $this->city = $address->city ?? '';
            $this->selectedCounty = $address->county_id ?? null;
        }
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }

    public function initiatePayment()
    {
        // First, handle user authentication/registration
        $user = $this->ensureUserAuthenticated();

        if (!$user) {
            return; // Validation failed or user creation failed
        }

        // Validate form
        $validated = $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(\+254|0)[1-9]\d{8}$/'],
            'address' => 'required|min:5',
            'city' => 'required',
            'selectedCounty' => 'required|exists:counties,id',
        ], [
            'phone.regex' => 'Please enter a valid Kenyan phone number (e.g., 0712345678 or +254712345678)',
            'selectedCounty.exists' => 'Please select a valid county.'
        ]);

        if (empty($this->cart)) {
            $this->dispatch('show-toast', [
                'message' => 'Your cart is empty!',
                'type' => 'error'
            ]);
            return;
        }

        if ($this->total <= 0) {
            $this->dispatch('show-toast', [
                'message' => 'Invalid order total!',
                'type' => 'error'
            ]);
            return;
        }

        // Save user address (but don't create order yet)
        $this->saveUserAddress($user->id);

        // Generate a unique order reference to pass to Paystack
        // This is NOT the actual order, just a reference for the payment
        do {
            $temporaryOrderReference = strtoupper(Str::random(9));
        } while (Order::where('order_number', $temporaryOrderReference)->exists());

        $this->temporaryOrderReference = $temporaryOrderReference;

        // Dispatch event to open Paystack modal
        $this->dispatch('paystack-payment', [
            'email' => $this->email,
            'amount' => $this->total * 100, // Convert to kobo
            'name' => $this->name,
            'phone' => $this->phone,
            'order_id' => $temporaryOrderReference, // Pass temporary reference
        ]);
    }

    protected function ensureUserAuthenticated()
    {
        // If user is already logged in, return the user
        if (Auth::check()) {
            return Auth::user();
        }

        // Validate user details
        $this->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^(\+254|0)[1-9]\d{8}$/'],
        ], [
            'phone.regex' => 'Please enter a valid Kenyan phone number (e.g., 0712345678 or +254712345678)',
            'email.unique' => 'This email is already registered. Please login instead.'
        ]);

        // Check if user exists with this email
        $existingUser = User::where('email', $this->email)->first();

        if ($existingUser) {
            // User exists but not logged in - ask them to login
            $this->dispatch('show-toast', [
                'message' => 'An account with this email already exists. Please login first.',
                'type' => 'error'
            ]);

            // Redirect to login page
            return redirect()->route('login', ['redirect' => route('store.checkout')]);
        }

        // Create new user with random password
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->randomPassword), // Random password
        ]);
        $user->syncRoles(['customer']);
        if (!$user) {
            $this->dispatch('show-toast', [
                'message' => 'Failed to create account. Please try again.',
                'type' => 'error'
            ]);
            return null;
        }
        $message = "Thanks for registering on Edymax Systems and Networks. 
        Your password is: " . $this->randomPassword . "
        Please update your password on the dashboard for security purposes.";
        // send sms with the password and prompt to change password
        $this->smsService->send($this->phone, $message);
        // Log the user in
        Auth::login($user);

        // Show success message
        $this->dispatch('show-toast', [
            'message' => 'Account created successfully! Please complete your address details.',
            'type' => 'success'
        ]);

        // Update component properties with new user data
        $this->name = $user->name;
        $this->email = $user->email;

        // Re-render the component to show the user is now logged in
        $this->dispatch('$refresh');

        return $user;
    }

    protected function saveUserAddress($userId)
    {
        // Validate address fields
        $this->validate([
            'phone' => ['required', 'regex:/^(\+254|0)[1-9]\d{8}$/'],
            'address' => 'required|min:5',
            'city' => 'required',
            'selectedCounty' => 'required|exists:counties,id',
        ], [
            'phone.regex' => 'Please enter a valid Kenyan phone number (e.g., 0712345678 or +254712345678)',
            'selectedCounty.exists' => 'Please select a valid county.'
        ]);

        $addressData = [
            'user_id' => $userId,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'county_id' => $this->selectedCounty,
        ];

        // Check if an address already exists for this user
        $existingAddress = Adresses::where('user_id', $userId)->first();

        if ($existingAddress) {
            $existingAddress->update($addressData);
        } else {
            Adresses::create($addressData);
        }
    }

    public function paymentSuccessful($reference)
    {
        // Verify the payment first
        $transactionCode = $this->verifyPaystackTransaction($reference['reference']);

        if (!$transactionCode) {
            $this->dispatch('show-toast', [
                'message' => 'Payment verification failed. Please contact support.',
                'type' => 'error'
            ]);
            return;
        }

        // ✅ Create order ONLY here after successful payment
        $order = $this->createOrder($reference);

        if (!$order) {
            $this->dispatch('show-toast', [
                'message' => 'Failed to create order. Please contact support.',
                'type' => 'error'
            ]);
            return;
        }

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'amount' => $this->total,
            'reference' => $reference['reference'],
            'transaction_code' => $transactionCode,
            'status' => PaymentStatus::PAID->value
        ]);

        // Send SMS notification
        $this->sendOrderSms($order);

        // ✅ Clear cart after order is created
        session()->forget('cart');
        $this->dispatch('cart-updated');

        return redirect()->route('customer.orders.show', $order->order_number);
    }

    protected function sendOrderSms($order)
    {
        try {
            // Get user's phone from address
            $address = $order->user->addresses->first();

            if (!$address || !$address->phone) {
                Log::warning('No phone number found for user', ['user_id' => $order->user_id]);
                return;
            }

            $userName = $order->user->name;
            $orderNumber = $order->order_number;
            $trackingUrl = route('customer.orders.show', $orderNumber);

            // Create SMS message
            $smsMessage = "Hi {$userName}, your order #{$orderNumber} has been received and is being processed. Track your order at: {$trackingUrl}";

            // Send SMS
            $response = $this->smsService->send($address->phone, $smsMessage);

            // Log SMS response
            if (isset($response['success']) && $response['success']) {
                Log::info('SMS sent successfully', [
                    'order_id' => $order->id,
                    'phone' => $address->phone,
                    'response' => $response
                ]);
            } else {
                Log::error('Failed to send SMS', [
                    'order_id' => $order->id,
                    'phone' => $address->phone,
                    'response' => $response ?? 'No response'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending SMS', [
                'order_id' => $order->id ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function paymentFailed()
    {
        // Clear the temporary order reference
        $this->temporaryOrderReference = null;

        // Notify the frontend (toast)
        $this->dispatch('show-toast', [
            'message' => 'Payment failed or was canceled. Please try again.',
            'type' => 'error'
        ]);
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

        return $payload['data']['receipt_number'] ?? $reference; // Use receipt number or fallback to reference
    }

    protected function createOrder($paymentData)
    {
        // Get products from cart
        $products_in_cart = $this->cart;

        // Generate final order number (use the temporary reference or generate new)
        $orderNumber = $this->temporaryOrderReference ?? strtoupper(Str::random(9));

        // Create the actual order
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'products' => json_encode($products_in_cart), // Encode all products at once
            'total_amount' => $this->total,
            'shipping_address' => $this->address,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($products_in_cart as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['price'] * $product['quantity'],
            ]);
        }

        // Clear the temporary reference
        $this->temporaryOrderReference = null;

        return $order;
    }

    public function getIsLoggedInProperty()
    {
        return Auth::check();
    }
}
