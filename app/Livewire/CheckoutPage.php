<?php

namespace App\Livewire;

use App\Models\Counties;
use App\Models\User;
use App\Models\Address;
use App\Models\Adresses;
use App\Models\Order;
use App\Models\Payment;
use App\PaymentStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

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

    public $createAccount = false;
    public $password;

    protected $listeners = [
        'payment-successful' => 'paymentSuccessful',
        'payment-failed' => 'paymentFailed'
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
        $this->counties = Counties::all();

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

        // Create order
        $order = $this->createOrder($validated);

        if (!$order) {
            return;
        }

        // Dispatch event to open Paystack modal
        $this->dispatch('paystack-payment', [
            'email' => $this->email,
            'amount' => $this->total * 100, // Convert to kobo
            'name' => $this->name,
            'phone' => $this->phone,
            'order_id' => $order->order_number,
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
            'password' => Hash::make('password'), // Random password
        ]);
        $user->syncRoles(['customer']);
        if (!$user) {
            $this->dispatch('show-toast', [
                'message' => 'Failed to create account. Please try again.',
                'type' => 'error'
            ]);
            return null;
        }

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
        $user = Auth::user();

        if ($user) {
            $this->saveUserAddress($user->id);
        }

        // ✅ Create order now
        $order = $this->createOrder($reference);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $this->total,
            'reference' => $reference['reference'],
            'transaction_code' => $this->verifyPaystackTransaction($reference['reference']),
            'status' => PaymentStatus::PAID->value
        ]);

        // ✅ NOW clear cart
        session()->forget('cart');
        $this->dispatch('cart-updated');

        return redirect()->route('customer.orders.show', $order->order_number);
    }

    public function paymentFailed()
    {
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

        return $payload['data']['receipt_number']; // ✅ clean verified data
    }

    protected function createOrder($paymentData)
    {
        // Generate unique order number
        do {
            $orderNumber = strtoupper(Str::random(9)); // 9 random uppercase letters
        } while (Order::where('order_number', $orderNumber)->exists());

        // Save order to database
        $order = Order::create([
            'user_id' => Auth::user()->id, // logged in user or null for guest
            'order_number' => $orderNumber,
            'products' => json_encode($this->cart),
            'total_amount' => $this->total,
            'shipping_address' => $this->address,
            'status' => 'pending',
        ]);



        // Clear cart
        return $order;
    }


    public function getIsLoggedInProperty()
    {
        return Auth::check();
    }

    // Remove the old registerUserDetails method as it's now handled in ensureUserAuthenticated
}
