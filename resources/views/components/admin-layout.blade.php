@props(['header' => null])

<x-app-layout>
    @if(auth()->user()?->isAdmin())
        @if($header)
            <x-slot name="header">
                {{ $header }}
            </x-slot>
        @endif

        {{ $slot }}
    @else
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-red-600 text-center">
                {{ __("Access denied") }}
            </h2>
        </x-slot>

        <div class="p-6 text-center text-red-600">
            {{ __("You don’t have access to this page. Please contact your manager!") }}
        </div>
    @endif
</x-app-layout>
