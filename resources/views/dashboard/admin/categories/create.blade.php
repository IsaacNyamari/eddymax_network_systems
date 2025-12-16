@extends('dashboard.layouts.dashboard')
@section('title', 'Create Category')
@section('content')
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-3">
            <a href="{{ route('admin.categories.index') }}"
                class="px-4 py-2 rounded-lg text-white  bg-gradient-to-tr via-gray-800 bg-red-700"><i
                    class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
            </a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                        class="p-3 space-y-3">
                        @csrf

                        <!-- Category Name -->
                        <div>
                            <x-input-label for="name" value="Category Names (comma separated)" />

                            <textarea id="name" name="name" rows="3" class="w-full border rounded p-2"
                                placeholder="monitors, desktops, laptops, pos">{{ old('name') }}</textarea>

                            @error('name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Parent Category -->
                        <div>
                            <x-input-label for="parent_category" value="Parent Category" />
                            <select id="parent_category" name="parent_category" class="w-full border rounded p-2">
                                <option value="">No Parent</option>
                                @foreach ($categories as $category)
                                    <option value="{{ (int) $category->id }}"
                                        {{ old('parent_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_category')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Category Image -->
                        <div>
                            <x-input-label for="image" value="Category Image" />
                            <input id="image" type="file" name="image" class="w-full border rounded p-2" />
                            @error('image')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-red-700 px-4 py-2 rounded-lg text-white">
                            Create Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
