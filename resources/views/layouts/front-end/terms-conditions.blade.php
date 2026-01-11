@extends('layouts.front-end.app')
@section('title', 'Terms and Conditions')
@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-red-800 to-blue-900 py-16 shadow-xl">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Terms and Conditions</h1>
                <p class="text-xl text-gray-200 max-w-3xl mx-auto">Legal agreement between you and {{ config('app.name') }}
                </p>
                <div class="mt-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 text-red-500 text-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M9.504 1.132a1 1 0 01.992 0l1.75 1a1 1 0 11-.992 1.736L10 3.152l-1.254.716a1 1 0 11-.992-1.736l1.75-1zM5.618 4.504a1 1 0 01-.372 1.364L5.016 6l.23.132a1 1 0 11-.992 1.736L4 7.723V8a1 1 0 01-2 0V6a.996.996 0 01.52-.878l1.734-.99a1 1 0 011.364.372zm8.764 0a1 1 0 011.364-.372l1.733.99A1.002 1.002 0 0118 6v2a1 1 0 11-2 0v-.277l-.254.145a1 1 0 11-.992-1.736l.23-.132-.23-.132a1 1 0 01-.372-1.364zm-7 4a1 1 0 011.364-.372L10 8.848l1.254-.716a1 1 0 11.992 1.736L11 10.58V12a1 1 0 11-2 0v-1.42l-1.246-.712a1 1 0 01-.372-1.364zM3 11a1 1 0 011 1v1.42l1.246.712a1 1 0 11-.992 1.736l-1.75-1A1 1 0 012 14v-2a1 1 0 011-1zm14 0a1 1 0 011 1v2a1 1 0 01-.504.868l-1.75 1a1 1 0 11-.992-1.736L16 13.42V12a1 1 0 011-1zm-9.618 5.504a1 1 0 011.364-.372l.254.145V16a1 1 0 112 0v.277l.254-.145a1 1 0 11.992 1.736l-1.735.992a.995.995 0 01-1.022 0l-1.735-.992a1 1 0 01-.372-1.364z"
                                clip-rule="evenodd" />
                        </svg>
                        Effective Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Quick Summary -->
                <div class="bg-gradient-to-r from-red-900 to-blue-900 text-white p-8">
                    <h2 class="text-2xl font-bold mb-4">Key Points Summary</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-300 mb-2">§1</div>
                            <h4 class="font-semibold mb-2">Acceptance of Terms</h4>
                            <p class="text-sm text-gray-200">By using our services, you agree to these terms</p>
                        </div>
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-red-300 mb-2">§2</div>
                            <h4 class="font-semibold mb-2">Account Responsibility</h4>
                            <p class="text-sm text-gray-200">You are responsible for your account security</p>
                        </div>
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-300 mb-2">§3</div>
                            <h4 class="font-semibold mb-2">Order & Payment</h4>
                            <p class="text-sm text-gray-200">Clear order and payment terms</p>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-8">
                    <!-- Acceptance Section -->
                    <div class="mb-12 pb-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-red-100 text-red-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                1
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Acceptance of Terms</h3>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-gray-700 mb-4">
                                By accessing and using {{ config('app.name') }}'s website and services, you accept and agree
                                to be bound by these Terms and Conditions. If you disagree with any part, you may not access
                                our services.
                            </p>
                            <div class="flex items-center p-4 bg-white rounded border border-gray-200">
                                <svg class="w-6 h-6 text-blue-600 mr-4 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-gray-600">
                                    <strong class="text-gray-900">Important:</strong> These terms constitute a legal
                                    agreement between you and {{ config('app.name') }}. We reserve the right to modify these
                                    terms at any time.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Accounts Section -->
                    <div class="mb-12 pb-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                2
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">User Accounts</h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-white border border-gray-200 p-6 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Account Security
                                </h4>
                                <ul class="space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        You are responsible for maintaining account confidentiality
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        Notify us immediately of unauthorized access
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        We reserve the right to suspend accounts violating terms
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-white border border-gray-200 p-6 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Account Information
                                </h4>
                                <ul class="space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        Provide accurate and current information
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        One account per individual/organization
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        Accounts must not be shared or transferred
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Orders & Payments -->
                    <div class="mb-12 pb-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-red-100 text-red-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                3
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Orders & Payments</h3>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-gradient-to-r from-red-50 to-blue-50 p-6 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-3">Order Acceptance</h4>
                                <p class="text-gray-700 mb-4">
                                    All orders are subject to acceptance and availability. We reserve the right to refuse or
                                    cancel any order for any reason, including but not limited to:
                                </p>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded border border-gray-200">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm font-medium">Product Unavailability</span>
                                        </div>
                                        <p class="text-xs text-gray-600">Items out of stock or discontinued</p>
                                    </div>
                                    <div class="bg-white p-4 rounded border border-gray-200">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm font-medium">Pricing Errors</span>
                                        </div>
                                        <p class="text-xs text-gray-600">Incorrect pricing information</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Payment Methods</h4>
                                <div class="flex flex-wrap gap-3 mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">M-Pesa</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Credit/Debit
                                        Card</span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Bank
                                        Transfer</span>
                                </div>
                                <p class="text-gray-600 text-sm">
                                    All prices are in Kenyan Shillings (KES) and include applicable taxes unless stated
                                    otherwise. Payment must be completed before order processing begins.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping & Delivery -->
                    <div class="mb-12 pb-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                4
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Shipping & Delivery</h3>
                        </div>
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-5 rounded-lg text-center">
                                    <div class="text-red-600 text-2xl font-bold mb-2">1-3 Days</div>
                                    <p class="text-sm font-medium text-gray-900">Nairobi Metro</p>
                                    <p class="text-xs text-gray-600">Standard delivery</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-lg text-center">
                                    <div class="text-blue-600 text-2xl font-bold mb-2">3-7 Days</div>
                                    <p class="text-sm font-medium text-gray-900">Major Towns</p>
                                    <p class="text-xs text-gray-600">Countrywide delivery</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-lg text-center">
                                    <div class="text-red-600 text-2xl font-bold mb-2">5-10 Days</div>
                                    <p class="text-sm font-medium text-gray-900">Remote Areas</p>
                                    <p class="text-xs text-gray-600">Custom arrangements</p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 p-5 rounded-lg">
                                <p class="text-gray-700">
                                    Delivery times are estimates and may vary based on location, product availability, and
                                    carrier schedules. We are not liable for delivery delays beyond our control.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Intellectual Property -->
                    <div class="mb-12 pb-8 border-b border-gray-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-red-100 text-red-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                5
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Intellectual Property</h3>
                        </div>
                        <div class="bg-gradient-to-r from-red-50 to-blue-50 p-6 rounded-lg">
                            <p class="text-gray-700 mb-4">
                                All content on this website, including but not limited to text, graphics, logos, images, and
                                software, is the property of {{ config('app.name') }} or its content suppliers and is
                                protected by copyright laws.
                            </p>
                            <div class="bg-white p-4 rounded border border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-2">Restrictions:</h4>
                                <ul class="text-gray-600 text-sm space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        No reproduction without written permission
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        No modification or distribution of content
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        No use for commercial purposes without authorization
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Limitation of Liability -->
                    <div class="mb-12">
                        <div class="flex items-center mb-6">
                            <div
                                class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl mr-4">
                                6
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Limitation of Liability</h3>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <div class="flex items-start mb-4">
                                <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Important Disclaimer</h4>
                                    <p class="text-gray-600">
                                        {{ config('app.name') }} shall not be liable for any indirect, incidental, special,
                                        consequential, or punitive damages resulting from your use of or inability to use
                                        our services.
                                    </p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="text-sm text-gray-600">
                                        <strong class="text-gray-900">Maximum Liability:</strong> In no event shall our
                                        total liability exceed the amount paid by you for the specific product or service
                                        giving rise to the claim.
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="text-sm text-gray-600">
                                        <strong class="text-gray-900">Force Majeure:</strong> We are not liable for delays
                                        or failures in performance resulting from causes beyond our reasonable control.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Updates -->
                <div class="bg-gradient-to-r from-red-900 to-blue-900 p-8 text-white">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-2xl font-bold mb-4 text-center">Questions & Updates</h3>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="font-semibold mb-3">Contact Legal Team</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-300 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <a href="mailto:{{ env('SUPPORT_EMAIL') }}"
                                            class="hover:text-blue-300 transition">{{ env('SUPPORT_EMAIL') }}</a>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-300 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <a href="tel:+254723835303" class="hover:text-blue-300 transition">+254 723 835
                                            303</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-3">Policy Updates</h4>
                                <p class="text-sm text-gray-300">
                                    We may update these Terms and Conditions periodically. Continued use of our services
                                    after changes constitutes acceptance of the new terms.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
