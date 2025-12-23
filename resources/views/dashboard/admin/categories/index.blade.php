@extends('dashboard.layouts.dashboard')
@section('title', 'All Categories (' . \App\Models\Category::count() . ')')
@section('content')
    <div class="p-4 px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 transition">
                <i class="fa fa-plus-circle mr-2" aria-hidden="true"></i>
                New Category
            </a>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Products
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        #{{ $category->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.categories.show', $category) }}"
                                            class="text-red-600 hover:text-red-800 font-medium">
                                            {{ $category->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $category->parent?->name ?? 'No Parent' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                class="w-16 h-16 object-cover rounded" alt="{{ $category->name }}">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fa fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($category->is_active)
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ count($category->products) ?? 0 }} products
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.categories.show', $category) }}"
                                                class="text-blue-600 hover:text-blue-900" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p class="mt-4 text-lg font-medium text-gray-400">No categories found</p>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first category
                                        </p>
                                        <a href="{{ route('admin.categories.create') }}"
                                            class="mt-4 inline-flex items-center px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-700 transition">
                                            <i class="fa fa-plus-circle mr-2"></i>
                                            Create First Category
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($categories->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Optional: Add some hover effects */
        tr:hover {
            background-color: #f9fafb;
            transition: background-color 0.2s ease;
        }

        .actions button:hover,
        .actions a:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
    </style>
@endsection
