@php
    $count = \App\Http\Controllers\Client\ClientCartController::itemsCount();
    $isLong = strlen((string)$count) > 1;
@endphp

<div>
    <a href="{{ route('client.cart.index') }}" class="relative inline-flex items-center ml-20">
        <x-cart-logo/>

        @if($count > 0)
            <span class="-mt-3 inline-flex bg-red-600 text-white text-xs font-bold items-center justify-center
                {{ $isLong ? 'rounded-full px-1.5 py-0.5 min-w-[20px] h-4' : 'rounded-full h-4 w-4' }}">
                    {{ $count }}
            </span>
        @endif
    </a>
</div>
