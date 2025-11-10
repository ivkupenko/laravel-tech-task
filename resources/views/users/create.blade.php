<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Add New User</h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-3xl">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <x-input-label for="name" :value="'Name'" class="mt-4"/>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required/>

                <x-input-label for="email" :value="'Email'" class="mt-4"/>
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required/>

                <x-input-label for="gender_id" :value="'Gender'" class="mt-4"/>
                <select id="gender_id" name="gender_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Select gender --</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ ucfirst($gender->gender) }}</option>
                    @endforeach
                </select>

                <x-input-label for="age" :value="'Age'" class="mt-4"/>
                <x-text-input id="age" name="age" type="number" min="1" max="120" class="mt-1 block w-full"/>

                <x-input-label for="role_id" :value="'Role'" class="mt-4"/>
                <select id="role_id" name="role_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Select user role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id}}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>

                <div class="mt-6 flex justify-center gap-4">
                    <x-primary-button>Create</x-primary-button>
                    <x-secondary-link-button href="{{ route('users.index') }}">Cancel</x-secondary-link-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
