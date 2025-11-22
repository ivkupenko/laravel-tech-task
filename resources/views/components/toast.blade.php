<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 2500)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-3"
    class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50
           px-5 py-3 rounded-lg shadow-md border text-gray-800"
    :class="{
        'bg-green-50 border-green-300': '{{ $type }}' === 'success',
        'bg-red-50 border-red-300': '{{ $type }}' === 'warning',
        'bg-red-70 border-red-500': '{{ $type }}' === 'error',
    }"
>
    {{ $slot }}
</div>
