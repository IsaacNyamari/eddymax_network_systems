 <div class="overflow-x-auto">
     <table class="min-w-full divide-y divide-gray-200">
         <thead class="bg-gray-50">
             <tr>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                     Name</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                     Image</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                     Status</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                     Action</th>
             </tr>
         </thead>
         <tbody class="bg-white divide-y divide-gray-200">
             @php

             @endphp
             @forelse($categories as $category)
                 <tr class="hover:bg-gray-50">
                     <td class="px-6 py-4 whitespace-nowrap">
                         <a href="{{ route('admin.categories.show', $category->slug) }}"
                             class="text-red-600 hover:text-red-800 font-medium">
                             {{ $category->name }}
                         </a>
                         <p class="text-xs text-gray-500 mt-1">{{ $category->created_at->format('M d, Y') }}</p>
                     </td>

                     <td class="px-6 py-4 whitespace-nowrap">
                         <p class="text-sm font-medium text-gray-900">
                             <img src="{{ asset('storage/' . $category->image) }}" class="w-32 mb-2">
                         </p>
                     </td>
                     <td class="px-6 py-4 whitespace-nowrap">
                         <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">

                         </span>
                     </td>
                     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                         <a href="{{ route('admin.categories.show', $category->slug) }}"
                             class="text-red-600 hover:text-red-900 mr-3">View</a>
                         {{-- @if ($order->status === 'pending')
                             <a href="#" class="text-green-600 hover:text-green-900">Process</a>
                         @endif --}}
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
                         <p class="mt-2">No orders yet</p>
                     </td>
                 </tr>
             @endforelse
         </tbody>


     </table>
 </div>
