@extends('dashboard.layouts.dashboard')

@section('title', 'Products')
@section('content')
    <!-- Recent Products & Top Products -->
    <div class="grid grid-row-1 lg:grid-row-2 gap-6">
        <!-- Recent Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Active Products</h2>
                    <div class="float-end flex gap-3">
                        <a href="{{ route('admin.product.trash') }}"
                            class="text-sm text-white bg-red-600 px-4 rounded py-2 hover:text-white font-medium">
                            <i class="fas fa-trash-alt"></i> Trash
                        </a>
                        <a href="{{ route('admin.products.create') }}"
                            class="text-sm text-white bg-green-600 px-4 rounded py-2 hover:text-white font-medium">
                            + New
                        </a>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                        class="mb-4 rounded-lg bg-green-100 text-center border border-green-300 px-4 py-3 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img class="w-16" src="{{ asset('storage/' . $product->image) }}"
                                        alt="$product->name">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($product->name, 15, '...') }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <livewire:update-price-input :product="$product" />
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                    <a href="{{ route('admin.products.show', $product->slug) }}"
                                        class="text-white px-4 py-2 rounded bg-green-500 hover:text-white mr-3">View</a>
                                    @if (Str::limit($product->description, 3, '...'))
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="text-white px-4 py-2 rounded bg-orange-500 hover:text-white">Edit</a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-500 px-4 p-2 text-white rounded hover:bg-red-600 hover:text-white cursor-pointer"><i
                                                class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-2">No products yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
            <nav class="px-5 py-2">{{ $products->links() }}</nav>
        </div>
    </div>
@endsection
