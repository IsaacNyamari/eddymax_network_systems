<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Return Status Update</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: {{ in_array(strtolower($status), ['approved', 'completed']) ? '#10b981' : (in_array(strtolower($status), ['rejected', 'cancelled']) ? '#ef4444' : '#3b82f6') }};
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background-color: {{ in_array(strtolower($status), ['approved', 'completed']) ? '#d1fae5' : (in_array(strtolower($status), ['rejected', 'cancelled']) ? '#fee2e2' : '#dbeafe') }};
            color: {{ in_array(strtolower($status), ['approved', 'completed']) ? '#065f46' : (in_array(strtolower($status), ['rejected', 'cancelled']) ? '#991b1b' : '#1e40af') }};
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-details {
            background-color: #f8fafc;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            color: #6b7280;
            font-weight: 500;
        }

        .value {
            color: #111827;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }

        .note {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }

        .status-message {
            font-size: 16px;
            line-height: 1.8;
            color: #4b5563;
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
        }

        .return-id {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Return Request Status Update</h1>
            <p>Order #{{ $order->order->order_number ?? 'N/A' }}</p>
            <div class="return-id">Return ID: #{{ $order->id }}</div>
        </div>

        <div class="content">
            <div style="text-align: center; margin-bottom: 25px;">
                <span class="status-badge">{{ ucfirst($status) }}</span>
            </div>

            <p class="status-message">
                @php
                    $messages = [
                        'pending' =>
                            'Your return request has been received and is currently being reviewed by our team. We will process it within 2-3 business days.',
                        'approved' =>
                            'Your return request has been approved! Please follow the instructions below to complete the return process.',
                        'rejected' =>
                            'Your return request could not be processed. Please see the details below or contact our support team for more information.',
                        'processing' =>
                            'We have received your returned item and are currently inspecting it. You will be notified once the inspection is complete.',
                        'completed' =>
                            'Your return has been successfully processed. Any applicable refund has been issued to your original payment method.',
                        'cancelled' => 'Your return request has been cancelled as requested.',
                    ];
                    $defaultMessage = 'Your return request status has been updated. Please see the details below.';
                @endphp
                {{ $messages[strtolower($status)] ?? $defaultMessage }}
            </p>

            <div class="order-details">
                <h3 style="margin-top: 0; color: #374151;">Return Details</h3>

                <div class="detail-row">
                    <span class="label">Return ID:</span>
                    <span class="value">#{{ $order->id }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Order Number:</span>
                    <span class="value">#{{ $order->order->order_number ?? 'N/A' }}</span>
                </div>

                @if ($order->reason)
                    <div class="detail-row">
                        <span class="label">Return Reason:</span>
                        <span class="value">{{ $order->reason }}</span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="label">Return Requested:</span>
                    <span
                        class="value">{{ \Carbon\Carbon::parse($order->created_at)->format('F j, Y \a\t g:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Last Updated:</span>
                    <span
                        class="value">{{ \Carbon\Carbon::parse($order->updated_at)->format('F j, Y \a\t g:i A') }}</span>
                </div>

                {{-- If you have refund_amount in order or need to calculate it --}}
                @php
                    // Example: Calculate or retrieve refund amount if needed
                    // $refundAmount = $order->refund_amount ?? $order->calculateRefund();
                @endphp
                {{-- Uncomment if you have refund amount data
                @if (isset($refundAmount) && $refundAmount > 0)
                <div class="detail-row">
                    <span class="label">Refund Amount:</span>
                    <span class="value" style="color: #10b981;">{{ config('app.currency', '$') }}{{ number_format($refundAmount, 2) }}</span>
                </div>
                @endif
                --}}
            </div>

            @if (strtolower($status) == 'approved')
                <div class="note">
                    <strong>Next Steps:</strong>
                    <ul style="margin: 10px 0; padding-left: 20px;">
                        <li>Package the item securely in its original packaging if available</li>
                        <li>Include all accessories, manuals, and freebies</li>
                        <li>Attach the return label to the package</li>
                        <li>Drop off at the designated courier location</li>
                        <li>Keep your tracking number for reference</li>
                    </ul>
                    <p style="margin-top: 10px; margin-bottom: 0;">
                        <strong>Return Deadline:</strong>
                        {{ \Carbon\Carbon::parse($order->updated_at)->addDays(14)->format('F j, Y') }}
                    </p>
                </div>
            @endif

            @if (strtolower($status) == 'completed')
                <div
                    style="text-align: center; background-color: #d1fae5; padding: 15px; border-radius: 6px; margin: 20px 0;">
                    <strong style="color: #065f46; font-size: 16px;">
                        Return successfully completed.
                    </strong>
                    <p style="color: #047857; margin: 10px 0 0 0;">
                        @if (isset($refundAmount) && $refundAmount > 0)
                            A refund of {{ getenv('CURRENCY', 'Kshs') }}{{ number_format($refundAmount, 2) }} has
                            been issued.
                            It may take 5-10 business days to appear in your account.
                        @else
                            The return process is now complete. Thank you for your patience.
                        @endif
                    </p>
                </div>
            @endif
            {{--             
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/orders/' . $order->order_id) }}" class="button">
                    View Order Details
                </a>
                <br>
                <a href="{{ url('/returns/' . $order->id) }}" style="color: #3b82f6; text-decoration: none; font-size: 14px;">
                    View Return Details
                </a>
            </div> --}}

            <p style="color: #6b7280; font-size: 14px; text-align: center;">
                Need help? Contact our support team at
                {{-- <a href="mailto:support@{{ config('app.domain', 'example.com') }}" style="color: #3b82f6;">support@{{ config('app.domain', 'example.com') }}</a> --}}
                @if (config('app.phone'))
                    or call us at {{ getenv('PHONE') }}.
                @endif
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Your Company Name') }}. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 5px;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>

</html>
