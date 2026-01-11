@extends('layouts.front-end.app')
@section('title', 'Privacy Policy')
@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-red-800 to-blue-900 py-16 shadow-xl">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Privacy Policy</h1>
                <p class="text-xl text-gray-200 max-w-3xl mx-auto">How we collect, use, and protect your personal information
                </p>
                <div class="mt-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white bg-opacity-20 text-red-500 text-sm">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Last Updated: {{ \Carbon\Carbon::now()->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Introduction -->
                <div class="bg-gradient-to-r from-red-50 to-blue-50 p-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                    <p class="text-gray-700">
                        At <strong class="text-red-700">{{ config('app.name') }}</strong>, we take your privacy
                        seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your
                        information when you use our website and services.
                    </p>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Information We Collect -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-red-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Information We Collect</h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Personal Information</h4>
                                <ul class="text-gray-600 text-sm space-y-1">
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        Name and contact details
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        Email address and phone number
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-2">•</span>
                                        Billing and shipping addresses
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Technical Information</h4>
                                <ul class="text-gray-600 text-sm space-y-1">
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        IP address and browser type
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        Device information
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-600 mr-2">•</span>
                                        Usage data and cookies
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- How We Use Information -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">How We Use Your Information</h3>
                        </div>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="bg-white border border-gray-200 p-4 rounded-lg text-center">
                                <div
                                    class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900">Order Processing</h4>
                                <p class="text-gray-600 text-sm mt-2">Process and fulfill your orders</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg text-center">
                                <div
                                    class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900">Customer Support</h4>
                                <p class="text-gray-600 text-sm mt-2">Respond to your inquiries and requests</p>
                            </div>
                            <div class="bg-white border border-gray-200 p-4 rounded-lg text-center">
                                <div
                                    class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900">Improvement</h4>
                                <p class="text-gray-600 text-sm mt-2">Improve our website and services</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Security -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-red-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Data Security</h3>
                        </div>
                        <div class="bg-gradient-to-r from-red-50 to-blue-50 p-6 rounded-lg">
                            <p class="text-gray-700 mb-4">
                                We implement appropriate technical and organizational security measures to protect your
                                personal information against unauthorized access, alteration, disclosure, or destruction.
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                <div class="text-center">
                                    <div
                                        class="bg-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-red-600 font-bold">SSL</span>
                                    </div>
                                    <p class="text-xs text-gray-600">Encryption</p>
                                </div>
                                <div class="text-center">
                                    <div
                                        class="bg-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-blue-600 font-bold">2FA</span>
                                    </div>
                                    <p class="text-xs text-gray-600">Access Control</p>
                                </div>
                                <div class="text-center">
                                    <div
                                        class="bg-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-red-600 font-bold">GDPR</span>
                                    </div>
                                    <p class="text-xs text-gray-600">Compliance</p>
                                </div>
                                <div class="text-center">
                                    <div
                                        class="bg-white w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-blue-600 font-bold">24/7</span>
                                    </div>
                                    <p class="text-xs text-gray-600">Monitoring</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cookies -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a6 6 0 0112 0c0 .459-.031.909-.086 1.333A5 5 0 0010 11z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Cookies & Tracking</h3>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <p class="text-gray-700 mb-4">
                                We use cookies and similar tracking technologies to enhance your browsing experience,
                                analyze website traffic, and understand where our visitors come from.
                            </p>
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-900">Manage Cookie Preferences</p>
                                    <p class="text-sm text-gray-600">You can control cookies through your browser settings
                                    </p>
                                </div>
                                <button
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    Learn More
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Your Rights -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-red-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Your Rights</h3>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-3">You have the right to:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Access your personal data</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Correct inaccurate data</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700">Request data deletion</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-3">Contact Information:</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <a href="mailto:privacy@netequip.co.ke"
                                            class="text-gray-700 hover:text-red-600">privacy@netequip.co.ke</a>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <a href="tel:+254723835303" class="text-gray-700 hover:text-red-600">+254 723
                                            835 303</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
