@extends('dashboard.layouts.dashboard')
@section('title', 'Order Return Requests')

@section('content')
    <div class="space-y-6">

        <a href="{{ route('admin.orders.index') }}" >
            <h2
                class="text-xl font-semibold bg-red-400 w-fit px-4 py-2 rounded cursor-pointer text-gray-900 hover:text-white">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>Back
            </h2>
        </a>
        <div id="returnStatus" class="position fixed top-10 right-5">

        </div>
        @forelse ($orders as $return)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Order #{{ $return->order->order_number ?? $return->order->id }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            Requested {{ $return->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div>
                        <a class="text-white px-4 bg-blue-800 py-2 rounded-xl"
                            href="{{ route('admin.orders.returns.show', $return) }}">View Return Details</a>
                    </div>
                </div>

                <!-- Body -->
                <div class="text-sm text-gray-700 space-y-2 border-red-700 border-l-4 pl-3 flex flex-row justify-between">
                    <div class="left-0">
                        <p>
                            <span class="font-medium">Order Status:</span>
                            {{ ucfirst($return->status) }}
                        </p>

                        <p>
                            <span class="font-medium">Return Reason:</span>
                            {{ $return->reason }}
                        </p>

                        <p>
                            <span class="font-medium">Order Date:</span>
                            {{ $return->order->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    {{-- <div class="float-right">
                        <livewire:return-actions :return="$return" />
                    </div> --}}
                </div>

            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center text-gray-500">
                You have no return requests yet.
            </div>
        @endforelse

    </div>
    <script>
        let returnStatus = document.getElementById("returnStatus");

        document.addEventListener('livewire:init', () => {
            Livewire.on('return-updated', (event) => {
                let message = event[0].message;
                let toast = document.createElement("div");
                toast.classList.add('slide-in')
                toast.classList.add('bg-green-500', 'text-white', 'p-3', 'border-l-black', 'border-l-4',
                    'mb-2');
                toast.innerHTML = message
                returnStatus.appendChild(toast)
                returnStatus.classList.remove('hidden');

                setTimeout(() => {
                    toast.remove()
                }, 3000);
            })
            Livewire.on('refund-made', (event) => {
                let message = event[0].message;
                let toast = document.createElement("div");
                toast.classList.add('slide-in')
                toast.classList.add('bg-green-500', 'text-white', 'p-3', 'border-l-black', 'border-l-4',
                    'mb-2');
                toast.innerHTML = message
                returnStatus.appendChild(toast)
                returnStatus.classList.remove('hidden');

                setTimeout(() => {
                    toast.remove()
                }, 3000);
            })
        })
    </script>
@endsection
