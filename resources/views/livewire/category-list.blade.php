<div>
    @foreach ($categories as $category)
        <span
            class="px-4 py-2 mb-2 bg-gray-100 text-gray-800 rounded-lg font-semibold hover:bg-red-100 cursor-pointer transition">
            {{ $category->name }}
        </span>
    @endforeach
</div>
