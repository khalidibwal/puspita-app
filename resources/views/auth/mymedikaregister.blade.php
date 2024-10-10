<x-guest-layout>
    <form method="POST" action="{{ route('register.medika') }}">
        @csrf

        <!-- Full Name -->
        <div>
            <x-input-label for="fullName" :value="__('Full Name')" />
            <x-text-input id="fullName" class="block mt-1 w-full" type="text" name="fullName" :value="old('fullName')" required autofocus />
            <x-input-error :messages="$errors->get('fullName')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full" required>
                <option value="1">Admin</option>
                <option value="2">SuperAdmin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Active -->
        <div class="mt-4">
            <x-input-label for="active" :value="__('Active')" />
            <input id="active" type="checkbox" name="active" value="1" class="mt-1" />
            <x-input-error :messages="$errors->get('active')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
