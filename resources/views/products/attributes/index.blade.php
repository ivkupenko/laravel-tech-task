<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Product Attributes') }}</h2>
    </x-slot>

    <div class="min-w-full py-8 px-4 flex flex-col items-center">
        <x-primary-link-button href="{{ route('attributes.create') }}">Add Attribute</x-primary-link-button>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Values</th>
                <th class="px-4 py-2 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($attributes as $attribute)
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold">{{ $attribute->name }}</td>
                    <td class="px-4 py-2">{{ $attribute->values->pluck('value')->join(', ') ?: '—' }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <div>
                            <form method="POST" action="{{ route('attributes.destroy', $attribute) }}" class="inline"
                                  onsubmit="return confirm('Delete this attribute?');">
                                @csrf
                                @method('DELETE')
                                <x-secondary-link-button href="{{ route('attributes.edit', $attribute) }}">Edit
                                </x-secondary-link-button>
                                <x-danger-button>Delete</x-danger-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">No attributes found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
