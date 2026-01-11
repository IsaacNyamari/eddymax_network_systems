@extends('layouts.front-end.app')
@section('title', 'Returns & Refund')
@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-red-800 to-blue-900 py-16 shadow-xl">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Returns & Refund Policy</h1>
                <p class="text-xl text-gray-200 max-w-3xl mx-auto">Your satisfaction is our priority. Read our transparent
                    return and refund guidelines</p>
                <div class="mt-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 text-red-900 text-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Updated: {{ \Carbon\Carbon::now()->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Policy Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <!-- Overview Card -->
                <div class="bg-gradient-to-r from-red-50 to-blue-50 p-8 border-b border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 p-3 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Policy Overview</h2>
                            <p class="text-gray-600 mt-1">Simple, transparent, and customer-friendly</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg">
                        At <strong class="text-red-700">{{ config('app.name') }}</strong>, we're committed to your
                        satisfaction. If you're not completely happy with your purchase, here's how we make it right.
                    </p>
                </div>

                <!-- Policy Sections -->
                <div class="p-8 space-y-12">
                    <!-- Returns Section -->
                    <div class="grid md:grid-cols-3 gap-8 items-start">
                        <div class="md:col-span-1">
                            <div class="sticky top-24">
                                <div
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-semibold mb-2">
                                    <span class="w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                    Section 1
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Returns</h3>
                                <p class="text-gray-600 mt-2">Easy return process within 14 days</p>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">14-Day Return Window</h4>
                            </div>
                            <p class="text-gray-700 mb-4">Return eligible items within <strong class="text-red-700">14
                                    days</strong> of delivery. To qualify:</p>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Product must be unused in original packaging</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Include all accessories, manuals, and warranty cards</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Products damaged by misuse are not returnable</span>
                                </li>
                            </ul>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-800 text-sm font-medium">💡 <strong>Tip:</strong> Keep your original
                                    packaging until you're sure you want to keep the product.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Refunds Section -->
                    <div class="grid md:grid-cols-3 gap-8 items-start">
                        <div class="md:col-span-1">
                            <div class="sticky top-24">
                                <div
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-semibold mb-2">
                                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                    Section 2
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Refunds</h3>
                                <p class="text-gray-600 mt-2">Quick and hassle-free refund process</p>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-white p-5 rounded-lg border border-gray-200">
                                    <div class="text-red-600 mb-3">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"
                                                clip-rule="evenodd" />
                                            <path d="M3 8v5a2 2 0 002 2h10a2 2 0 002-2V8H3z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Processing Time</h4>
                                    <p class="text-gray-600 text-sm">Refunds processed within <strong
                                            class="text-red-700">5-7 business days</strong> after approval</p>
                                </div>
                                <div class="bg-white p-5 rounded-lg border border-gray-200">
                                    <div class="text-blue-600 mb-3">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"
                                                clip-rule="evenodd" />
                                            <path d="M3 8v5a2 2 0 002 2h10a2 2 0 002-2V8H3z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Payment Methods</h4>
                                    <p class="text-gray-600 text-sm">Refunds issued to original payment method (M-Pesa,
                                        Card, or Bank Transfer)</p>
                                </div>
                            </div>
                            <div class="bg-red-50 border border-red-100 rounded-lg p-4">
                                <p class="text-red-800 text-sm">⚠️ <strong>Note:</strong> Shipping costs are
                                    non-refundable except for defective or incorrect items.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Sections in similar structure -->
                    <!-- Damaged Items -->
                    <div class="grid md:grid-cols-3 gap-8 items-start">
                        <div class="md:col-span-1">
                            <div class="sticky top-24">
                                <div
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-semibold mb-2">
                                    <span class="w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                    Section 3
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Damaged Items</h3>
                                <p class="text-gray-600 mt-2">Report within 48 hours of delivery</p>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Immediate Action Required</h4>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-start">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-red-100 text-red-800 rounded-full text-xs font-bold flex items-center justify-center mr-3">1</span>
                                    <span>Contact us within <strong>48 hours</strong> of delivery</span>
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-red-100 text-red-800 rounded-full text-xs font-bold flex items-center justify-center mr-3">2</span>
                                    <span>Provide photos of damaged item and packaging</span>
                                </li>
                                <li class="flex items-start">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-red-100 text-red-800 rounded-full text-xs font-bold flex items-center justify-center mr-3">3</span>
                                    <span>We'll replace or issue full refund including shipping</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Non-Returnable Items -->
                    <div class="grid md:grid-cols-3 gap-8 items-start">
                        <div class="md:col-span-1">
                            <div class="sticky top-24">
                                <div
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-semibold mb-2">
                                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                    Section 4
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Non-Returnable Items</h3>
                                <p class="text-gray-600 mt-2">Items not eligible for return</p>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg border border-red-200">
                                    <div class="flex items-center mb-2">
                                        <div class="bg-red-100 p-2 rounded mr-3">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">Custom Equipment</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm">Custom-configured networking gear</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-red-200">
                                    <div class="flex items-center mb-2">
                                        <div class="bg-red-100 p-2 rounded mr-3">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">Opened Software</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm">Software licenses or activation codes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="bg-gradient-to-r from-red-900 to-blue-900 p-8 text-white">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-2xl font-bold mb-6 text-center">Need Help with Returns?</h3>
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div
                                    class="bg-white bg-opacity-20 w-12 text-red-900 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <p class="font-semibold">Email Support</p>
                                <a href="mailto:{{ env('SUPPORT_EMAIL') }}"
                                    class="text-blue-300 hover:text-white transition">{{ env('SUPPORT_EMAIL') }}</a>
                            </div>
                            <div class="text-center">
                                <div
                                    class="bg-white bg-opacity-20 w-12 h-12 text-red-900 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <p class="font-semibold">Phone Support</p>
                                <a href="tel:+254723835303" class="text-blue-300 hover:text-white transition">+254 723 835
                                    303</a>
                            </div>
                            <div class="text-center">
                                <div
                                    class="bg-white bg-opacity-20 w-12 h-12 text-red-900 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="font-semibold">Working Hours</p>
                                <p class="text-sm">Mon-Fri: 9AM-6PM<br>Sat: 10AM-4PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <span
                                class="bg-red-100 text-red-800 rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">Q</span>
                            How long does the refund take?
                        </h4>
                        <p class="text-gray-600 text-sm">Refunds are processed within 5-7 business days after we receive
                            and inspect the returned item.</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <span
                                class="bg-blue-100 text-blue-800 rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">Q</span>
                            Who pays for return shipping?
                        </h4>
                        <p class="text-gray-600 text-sm">Customers pay return shipping unless the return is due to our
                            error or defective product.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
