@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Return & Refund Policy</h1>

        <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
            <p class="text-gray-700 text-lg">
               At <strong> {{ config('app.name') }} </strong>, your satisfaction is our top priority. If you are not fully
                satisfied with your purchase, please review our return and refund policy below:
            </p>

            <div class="space-y-4">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Returns</h2>
                    <p class="text-gray-700">
                        You may return products within <strong>14 days</strong> from the date of delivery. To be eligible
                        for a return:
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>The product must be unused and in the original packaging.</li>
                        <li>All accessories, manuals, and warranty cards must be included.</li>
                        <li>Products damaged due to misuse or improper handling cannot be returned.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Refunds</h2>
                    <p class="text-gray-700">
                        Once your return is received and inspected, we will notify you via email regarding the approval or
                        rejection of your refund. If approved:
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Refunds will be processed within <strong>5-7 business days</strong>.</li>
                        <li>Refunds will be issued using the original payment method (M-Pesa, Card, or Bank Transfer).</li>
                        <li>Shipping costs are non-refundable unless the return is due to a defective or incorrect item.
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Damaged or Defective Items</h2>
                    <p class="text-gray-700">
                        If your item arrives damaged, defective, or not as ordered:
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Contact us within <strong>48 hours</strong> of delivery.</li>
                        <li>Provide photos of the damaged item and packaging.</li>
                        <li>We will either replace the item or issue a full refund including shipping.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">4. Exchanges</h2>
                    <p class="text-gray-700">
                        We currently do not offer direct exchanges. To replace a product, please initiate a return and place
                        a new order.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">5. Non-Returnable Items</h2>
                    <p class="text-gray-700">
                        The following items cannot be returned:
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Custom-configured networking equipment</li>
                        <li>Opened software, licenses, or activation codes</li>
                        <li>Items damaged by the customer</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">6. Contact Support</h2>
                    <p class="text-gray-700">
                        For any questions or assistance regarding returns or refunds, please reach out to our support team:
                    </p>
                    <ul class="list-disc list-inside text-gray-700">
                        <li>Email: <a href="mailto:support@netequip.co.ke"
                                class="text-red-600 hover:underline">support@netequip.co.ke</a></li>
                        <li>Phone: +254 723 835 303</li>
                        <li>Working Hours: Mon-Fri 9:00 AM - 6:00 PM, Sat 10:00 AM - 4:00 PM</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
@endsection
