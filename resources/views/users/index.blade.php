<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="min-w-full py-8 px-4 flex flex-col items-center">
        <form method="GET" action="{{ route('users.index') }}" class="mb-6 flex flex-wrap gap-6 items-end">
            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text"
                              value="{{ request('name') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input id="email" name="email" type="text"
                              value="{{ request('email') }}"
                              class="mt-1 block h-9"/>
            </div>

            <div class="mt-4">
                <x-input-label for="gender_id" :value="__('Gender')"/>
                <select id="gender_id" name="gender_id"
                        class="block mt-1 h-9 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <option value=""
                            disabled {{ (old('gender_id') || (isset($user) && $user->gender_id)) ? '' : 'selected' }}></option>

                    @foreach(\App\Models\Gender::all() as $gender)
                        <option value="{{ $gender->id }}"
                            {{ (string) old('gender_id', $user->gender_id ?? '') === (string) $gender->id ? 'selected' : '' }}>
                            {{ ucfirst($gender->gender) }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('gender_id')" class="mt-2"/>
            </div>

            <div class="flex gap-2 items-end">
                <div>
                    <x-input-label for="age_from" :value="__('Age From')"/>
                    <x-text-input id="age_from" name="age_from" type="number"
                                  value="{{ request('age_from') }}"
                                  class="mt-1 block w-24 h-9"/>
                </div>

                <div>
                    <x-input-label for="age_to" :value="__('Age To')"/>
                    <x-text-input id="age_to" name="age_to" type="number"
                                  value="{{ request('age_to') }}"
                                  class="mt-1 block w-24 h-9"/>
                </div>
            </div>

            <div class="flex gap-2 mt-1">
                <x-primary-button>{{ __('Filter') }}</x-primary-button>
                <x-secondary-link-button href="{{ route('users.index') }}">{{ __('Reset') }}</x-secondary-link-button>
            </div>
        </form>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 mt-1 text-left">Name</th>
                <th class="px-4 py-2 mt-1 text-left">Email</th>
                <th class="px-4 py-2 mt-1 text-left">Gender</th>
                <th class="px-4 py-2 mt-1 text-left">Age</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ ucfirst($user->gender->gender) }}</td>
                    <td class="px-4 py-2">{{ $user->age}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                        No users found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
