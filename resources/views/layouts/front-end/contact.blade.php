@extends('layouts.front-end.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <!-- Page Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Contact Us</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Send Us a Message</h2>
                <form>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-gray-700 font-semibold mb-1">Name</label>
                            <input type="text" id="name" name="name" placeholder="Your Name"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                            <input type="email" id="email" name="email" placeholder="Your Email"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label for="message" class="block text-gray-700 font-semibold mb-1">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Your Message"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                        </div>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition transform hover:-translate-y-1 shadow-lg">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-8 space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Our Address</h2>
                        <p class="text-gray-700">{{ config("settings.location") }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-8 space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Call Us</h2>
                        <p class="text-gray-700">{{ config('settings.phone') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 space-y-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Email Us</h2>
                    <p class="text-gray-700">{{ config('settings.support_email') }}</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 space-y-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Working Hours</h2>
                    <p class="text-gray-700">Monday - Friday: 9:00 AM - 6:00 PM</p>
                    <p class="text-gray-700">Saturday: 10:00 AM - 4:00 PM</p>
                    <p class="text-gray-700">Sunday: Closed</p>
                </div>


            </div>

        </div>
        <!-- Map Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7613929722406!2d36.88612648885499!3d-1.318843399999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1247f8014ea5%3A0xb729f1a6dc151987!2sHoney%20Suckle%20Gardens%20Estate!5e0!3m2!1sen!2ske!4v1765459471194!5m2!1sen!2ske"
                width="600" height="450" style="border:0;" allowfullscreen="" class="w-screen" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
@endsection
