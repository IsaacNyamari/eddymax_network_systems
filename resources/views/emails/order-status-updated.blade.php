<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .status-card {
            background: linear-gradient(135deg, #f6f9ff 0%, #f0f4ff 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #e0e7ff;
            text-align: center;
        }

        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .status-text {
            font-size: 20px;
            color: #4f46e5;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .order-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #e2e8f0;
        }

        .order-number {
            font-size: 22px;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .products-section {
            margin: 40px 0;
        }

        .section-title {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-details {
            padding: 20px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .product-quantity {
            background: #f3f4f6;
            color: #6b7280;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .product-price {
            color: #10b981;
            font-weight: 700;
            font-size: 16px;
        }

        .image-fallback {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 40px;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, maroon 0%, blue 100%);
            color: white !important;
            text-decoration: none;
            padding: 16px 36px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .footer {
            text-align: center;
            padding: 30px;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }

        @media (max-width: 600px) {

            .header,
            .content {
                padding: 20px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Order Status Updated</h1>
            <p>Your order has been updated</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Hello <strong>{{ $order->user->name }}</strong>,
            </div>

            <!-- Status Update -->
            <div class="status-card">
                <div class="status-icon">
                    @php
                        $statusIcons = [
                            'DELIVERED' => '✅',
                            'SHIPPED' => '🚚',
                            'PROCESSING' => '⚙️',
                            'CANCELLED' => '❌',
                            'PENDING' => '⏳',
                            'delivered' => '✅',
                            'shipped' => '🚚',
                            'processing' => '⚙️',
                            'cancelled' => '❌',
                            'pending' => '⏳',
                        ];
                        echo $statusIcons[strtoupper($status)] ?? '📦';
                    @endphp
                </div>
                <div class="status-text" style="text-transform: uppercase;">
                    {{ $status }}
                </div>
                <div class="status-action">{{ $action }}</div>
            </div>

            <!-- Order Information -->
            <div class="order-info">
                <div class="order-number">
                    Order #{{ $order->order_number }}
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div
                        style="background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div
                            style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                            Order Date
                        </div>
                        <div style="font-size: 16px; color: #2d3748; font-weight: 600;">
                            {{ date('F d, Y', strtotime($order->created_at)) }}
                        </div>
                    </div>

                    <div
                        style="background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div
                            style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                            Updated On
                        </div>
                        <div style="font-size: 16px; color: #2d3748; font-weight: 600;">
                            {{ date('F d, Y \\a\\t h:i A') }}
                        </div>
                    </div>

                    @if ($order->total_amount)
                        <div
                            style="background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <div
                                style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                                Total Amount
                            </div>
                            <div style="font-size: 16px; color: #2d3748; font-weight: 600;">
                                KSh {{ number_format($order->total_amount, 2) }}
                            </div>
                        </div>
                    @endif

                    @if ($order->shipping_address)
                        <div
                            style="background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <div
                                style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                                Shipping Address
                            </div>
                            <div style="font-size: 14px; color: #2d3748; font-weight: 500;">
                                {{ $order->shipping_address }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Products Section -->
            @if (count($products) > 0)
                <div class="products-section">
                    <h2 class="section-title">
                        🛍️ Your Order Items ({{ count($products) }})
                    </h2>

                    <div class="products-grid">
                        @foreach ($products as $product)
                            <div class="product-card">
                                <!-- Base64 Encoded Image -->
                                @if ($product['has_image'])
                                    <img src="data:{{ $product['mime_type'] }};base64,{{ $product['image_data'] }}"
                                        alt="{{ $product['name'] }}" class="product-image">
                                @else
                                    <div class="image-fallback">
                                        📦
                                    </div>
                                @endif

                                <div class="product-details">
                                    <div class="product-name">
                                        {{ $product['name'] }}
                                    </div>

                                    <div class="product-meta">
                                        <span class="product-quantity">
                                            Qty: {{ $product['quantity'] }}
                                        </span>
                                        @if ($product['price'])
                                            <span class="product-price">
                                                KSh {{ number_format($product['price'], 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div
                        style="margin-top: 30px; padding: 25px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 18px; color: #2d3748; font-weight: 600;">
                                Order Total
                            </span>
                            <span style="font-size: 28px; color: #10b981; font-weight: 700;">
                                KSh {{ number_format($order->total_amount, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Specific Messages -->
            @if (strtolower($status) == 'delivered')
                <div
                    style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 12px; padding: 25px; margin: 30px 0; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 10px;">🎉</div>
                    <h3 style="color: #065f46; margin-bottom: 10px;">Delivery Complete!</h3>
                    <p style="color: #047857; margin-bottom: 15px;">
                        Your order has been successfully delivered to {{ $order->shipping_address }}.
                        We hope you enjoy your purchase!
                    </p>
                </div>
            @endif

            @if (strtolower($status) == 'shipped')
                <div
                    style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; padding: 25px; margin: 30px 0; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 10px;">🚚</div>
                    <h3 style="color: #1e40af; margin-bottom: 10px;">Shipped!</h3>
                    <p style="color: #1e3a8a; margin-bottom: 15px;">
                        Your order is on its way to {{ $order->shipping_address }}.
                        Expect delivery soon!
                    </p>
                </div>
            @endif

            <!-- CTA Button -->
            <div style="text-align: center; margin: 40px 0;">
                <a href="{{ url('customer/orders/' . $order->order_number) }}" class="cta-button">
                    View Complete Order Details
                </a>
                <p style="color: #6b7280; font-size: 14px; margin-top: 15px;">
                    Click above to track your order and view details
                </p>
            </div>

            <!-- Support Info -->
            <div style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #e5e7eb; text-align: center;">
                <p style="color: #4b5563; font-size: 15px;">
                    Need help with your order?<br>
                    Reply to this email or contact our support team.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div style="color: #4f46e5; font-weight: 700; font-size: 18px; margin-bottom: 15px;">
                {{ config('app.name') }}
            </div>
            <div style="font-size: 13px; margin-top: 20px; color: #9ca3af;">
                This is an automated message. Please do not reply directly.<br>
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
