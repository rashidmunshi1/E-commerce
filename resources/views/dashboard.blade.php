@if (in_array(Auth::user()->role, ['admin', 'vendor']))
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
@if (Auth::user()->role == 'user')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Product List') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg w-full max-w-xs mx-auto">
                            <div class="p-4">
                                <img src="{{ asset('images/test-product.jpg') }}" alt=""
                                    class="w-30 h-20 object-cover rounded-md">
                                <h3 class="text-md font-semibold text-gray-900 dark:text-gray-100 mt-3">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 text-sm mt-1">
                                    {{ Str::limit($product->description, 50) }}
                                </p>
                                <p class="text-gray-900 dark:text-gray-200 font-bold mt-2">
                                    ₹{{ number_format($product->price, 2) }}
                                </p>
                                <div class="mt-4 flex gap-2">
                                    <button
                                        class="btn btn-primary px-3 py-1 text-white text-sm rounded hover:bg-blue-700">
                                        Add to Cart
                                    </button>
                                    <button
                                        class="btn btn-success px-3 py-1  text-white text-sm rounded hover:bg-green-700">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
