@extends('dashboard.layouts.dashboard')
@section('title', 'Return Details - #' . $return->order->order_number)

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Back to Orders</span>
        </a>
        <div class="bg-blue-700 z-50 hidden text-white px-4 py-2 border-lime-500 border-l-4 rounded-r-lg fixed top-10 right-5 capitalize"
            id="alertWait">
            requesting. please wait!
        </div>
        <div id="paymentDetails"
            class="grid z-50 grid-cols-2 justify-between fixed top-10 content-center items-center w-full">

        </div>
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Return Request #{{ $return->id }}</h1>
                <p class="text-gray-500 mt-1">Submitted
                    {{ $return->created_at->diffForHumans() }}</p>
            </div>

        </div>
        <!-- Status Notification -->
        <div id="returnStatus" class="fixed top-5 right-5 z-50"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Return Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Return Information Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Return ID</p>
                            <p class="font-medium">#{{ $return->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Order Number</p>
                            <p class="font-medium">{{ $return->order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Order Status</p>
                            <p class="font-medium capitalize">{{ $return->order->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="font-medium text-green-600">KES {{ number_format($return->order->total_amount, 2) }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Shipping Address</p>
                            <p class="font-medium">{{ $return->order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reason Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Reason</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $return->reason }}</p>
                    </div>
                </div>

                <!-- Product Details Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h2>
                    @php
                        $products = json_decode($return->order->products, true);
                        $product = reset($products); // Get first product
                    @endphp

                    @if ($product)
                        <div class="flex items-center space-x-4 p-4 border rounded-lg">
                            @if (isset($product['image']))
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                    class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $product['name'] }}</h3>
                                <p class="text-sm text-gray-500">Model: {{ $product['model'] ?? 'N/A' }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm text-gray-600">Price: KES
                                        {{ number_format($product['price'], 2) }}</span>
                                    <span class="text-sm text-gray-600">Quantity: {{ $product['quantity'] ?? 1 }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Proof Images Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Proof Files</h2>
                        <div class="flex items-center space-x-4">
                            @if ($return->images->count() > 0)
                                @php
                                    $imageCount = 0;
                                    $videoCount = 0;
                                    foreach ($return->images as $file) {
                                        $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                                        $videoExtensions = [
                                            'mp4',
                                            'mov',
                                            'avi',
                                            'wmv',
                                            'flv',
                                            'mkv',
                                            'webm',
                                            'm4v',
                                            'mpg',
                                            'mpeg',
                                        ];
                                        if (in_array($extension, $videoExtensions)) {
                                            $videoCount++;
                                        } else {
                                            $imageCount++;
                                        }
                                    }
                                @endphp
                                <div class="flex items-center space-x-2">
                                    @if ($imageCount > 0)
                                        <span class="inline-flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $imageCount }} image{{ $imageCount !== 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                    @if ($videoCount > 0)
                                        <span class="inline-flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            {{ $videoCount }} video{{ $videoCount !== 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($return->images->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($return->images as $file)
                                @php
                                    $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                                    $videoExtensions = [
                                        'mp4',
                                        'mov',
                                        'avi',
                                        'wmv',
                                        'flv',
                                        'mkv',
                                        'webm',
                                        'm4v',
                                        'mpg',
                                        'mpeg',
                                    ];
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                                    $isVideo = in_array($extension, $videoExtensions);
                                    $isImage = in_array($extension, $imageExtensions);
                                @endphp

                                <div class="relative group">
                                    @if ($isVideo)
                                        <!-- Video Player -->
                                        <div
                                            class="aspect-square overflow-hidden rounded-lg border border-gray-200 bg-black">
                                            <div class="relative w-full h-full">
                                                <!-- Video thumbnail with play button overlay -->
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                                                        <div class="text-center">
                                                            <svg class="w-12 h-12 mx-auto text-white opacity-70 mb-2"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs text-white opacity-80 uppercase">{{ $extension }}</span>
                                                        </div>
                                                    </div>
                                                    <!-- Play button overlay -->
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors cursor-pointer"
                                                            onclick="openVideoModal('{{ asset('storage/' . $file->path) }}')">
                                                            <svg class="w-8 h-8 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($isImage)
                                        <!-- Image Viewer -->
                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                            class="block aspect-square overflow-hidden rounded-lg border border-gray-200">
                                            <img src="{{ asset('storage/' . $file->path) }}" alt="Proof image"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        </a>
                                    @else
                                        <!-- Other file type -->
                                        <div
                                            class="aspect-square overflow-hidden rounded-lg border border-gray-200 bg-gray-100">
                                            <div class="w-full h-full flex flex-col items-center justify-center p-4">
                                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span
                                                    class="text-xs text-gray-600 font-medium">{{ strtoupper($extension) }}</span>
                                                <span class="text-xs text-gray-500 mt-1">File</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- File type badge -->
                                    <div class="absolute top-2 left-2">
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $isVideo
                                ? 'bg-purple-100 text-purple-800'
                                : ($isImage
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-gray-100 text-gray-800') }}">
                                            {{ $isVideo ? 'VIDEO' : ($isImage ? 'IMAGE' : strtoupper($extension)) }}
                                        </span>
                                    </div>

                                    <!-- Download button -->
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ asset('storage/' . $file->path) }}"
                                            download="{{ basename($file->path) }}"
                                            class="bg-white p-1.5 rounded-full shadow-sm hover:bg-gray-50 transition-colors"
                                            title="Download {{ basename($file->path) }}">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <!-- File name -->
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-600 truncate" title="{{ basename($file->path) }}">
                                            {{ \Illuminate\Support\Str::limit(basename($file->path), 20) }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $file->created_at->format('M d, Y') }}
                                            @if ($isVideo)
                                                <span class="ml-2">
                                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    Video
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No proof files uploaded</p>
                        </div>
                    @endif
                </div>

                <!-- Video Modal -->
                <div id="videoModal" class="fixed inset-0 z-50 hidden bg-black/90 items-center justify-center p-4">
                    <div class="relative w-full max-w-4xl">
                        <!-- Close button -->
                        <button onclick="closeVideoModal()"
                            class="absolute -top-12 right-0 z-10 text-white p-2 hover:text-gray-300 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Video player -->
                        <div class="bg-black rounded-lg overflow-hidden shadow-2xl">
                            <video id="modalVideo" class="w-full h-full" controls controlsList="nodownload"
                                preload="metadata">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <!-- Video info -->
                        <div class="mt-4 text-center">
                            <button onclick="downloadCurrentVideo()"
                                class="inline-flex items-center px-4 py-2 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Video
                            </button>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Right Column - Actions & Timeline -->
            <div class="space-y-6">
                <!-- Status Actions Card -->
                <div class="bg-white shadow rounded-lg p-6 sticky top-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                    <div class="space-y-3">
                        <livewire:return-actions :return="$return" />
                        <script>
                            function getRoute(status) {
                                const select = document.querySelector('select[name="status"]');
                                const selectedOption = select.options[select.selectedIndex];
                                return selectedOption.getAttribute('data-route');
                            }
                        </script>

                        <!-- Quick Actions -->
                        <div class="pt-4 border-t">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.orders.show', $return->order->order_number) }}"
                                    class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Timeline Card -->
                <livewire:admmin-returns-page-refresh :return="$return" />

                <!-- Customer Info Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $return->order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $return->order->user->email }}</p>
                            </div>
                        </div>
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-500 mb-1">Order Date</p>
                            <p class="font-medium">
                                {{ $return->order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        {{-- <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h2>
            <form action="{{ route('admin.returns.add-note', $return->id) }}" method="POST">
                @csrf
                <textarea name="notes" rows="3" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Add notes about this return..."></textarea>
                <div class="mt-3 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                        Save Note
                    </button>
                </div>
            </form>
        </div> --}}
    </div>

    <!-- JavaScript for Image Lightbox -->
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[src*="storage"]');
            images.forEach(img => {
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    const src = this.src;
                    const lightbox = document.createElement('div');
                    lightbox.className =
                        'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center';
                    lightbox.innerHTML = `
                    <div class="relative max-w-4xl max-h-full">
                        <img src="${src}" class="max-w-full max-h-screen">
                        <button onclick="this.parentElement.parentElement.remove()" 
                                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                    document.body.appendChild(lightbox);
                });
            });
        });

        // 2. Video modal functions
        let currentVideoUrl = '';

        function openVideoModal(videoUrl) {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideo');

            currentVideoUrl = videoUrl;
            video.src = videoUrl;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Play video when modal opens
            video.load();
            video.play().catch(e => {
                console.log('Autoplay prevented, user can play manually');
            });
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideo');

            video.pause();
            video.currentTime = 0;

            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function downloadCurrentVideo() {
            if (currentVideoUrl) {
                const link = document.createElement('a');
                link.href = currentVideoUrl;
                link.download = currentVideoUrl.split('/').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // 3. Livewire with SweetAlert integration
        document.addEventListener('livewire:init', () => {
            // Show loading alert when action buttons are clicked
            document.querySelectorAll(".actionButtons").forEach(button => {
                button.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your request',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            });

            // Handle successful return updates
            Livewire.on('return-updated', (result) => {
                Swal.close();

                const message = Array.isArray(result) ?
                    (result.message || result[0]) :
                    (result.message || result);

                Swal.fire({
                    title: 'Success!',
                    text: message || 'Return status updated successfully',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });

            // Handle low balance errors
            Livewire.on('low-balance', (result) => {
                Swal.close();

                const message = Array.isArray(result) ? result[0] : result;

                Swal.fire({
                    title: 'Insufficient Funds',
                    text: message || 'Unable to process refund due to insufficient balance',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    showCancelButton: true,
                    cancelButtonText: 'Contact Support',
                    cancelButtonColor: '#6c757d',
                }).then((result) => {
                    if (result.isDismissed && result.dismiss === 'cancel') {
                        // User clicked "Contact Support"
                        window.location.href = '/contact-support';
                    }
                });
            });

            // Handle payment success details
            Livewire.on('check-payment-success', (result) => {
                Swal.close();

                try {
                    const data = JSON.parse(result);

                    Swal.fire({
                        title: 'Payment Details',
                        html: `
                    <div class="text-left space-y-3">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-blue-700 font-medium mb-1">Status</p>
                            <p class="text-lg font-semibold text-blue-800">${data.message || 'Success'}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 font-medium mb-1">Paid via</p>
                                <p class="text-gray-800 font-semibold">${data.brand || 'N/A'}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 font-medium mb-1">M-Pesa Code</p>
                                <p class="text-gray-800 font-semibold">${data.receipt || 'N/A'}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 font-medium mb-1">Phone Number</p>
                                <p class="text-gray-800 font-semibold">${data.phone || 'N/A'}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 font-medium mb-1">Amount</p>
                                <p class="text-gray-800 font-semibold">${data.amount ? 'KES ' + data.amount : 'N/A'}</p>
                            </div>
                        </div>
                    </div>
                `,
                        icon: 'success',
                        width: '500px',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Close',
                        showCloseButton: true
                    });
                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Unable to display payment details',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Handle refund success
            Livewire.on('refund-made', (result) => {
                Swal.close();

                const message = Array.isArray(result) ?
                    (result.message || result[0]) :
                    (result.message || result);

                Swal.fire({
                    title: 'Refund Successful!',
                    text: message || 'Refund has been processed successfully',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true,
                });
            });
        });

        // 4. Event listeners for video modal
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeVideoModal();
                }
            });

            // Close modal when clicking outside (if videoModal exists)
            const videoModal = document.getElementById('videoModal');
            if (videoModal) {
                videoModal.addEventListener('click', function(e) {
                    if (e.target.id === 'videoModal') {
                        closeVideoModal();
                    }
                });
            }
        });

        // 5. Optional: Add custom CSS for SweetAlert
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.textContent = `
            .swal2-popup {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            }
            .swal2-title {
                color: #1f2937;
            }
            .swal2-html-container {
                color: #4b5563;
            }
        `;
            document.head.appendChild(style);
        });
    </script>
@endsection
