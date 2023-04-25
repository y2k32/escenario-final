<x-app-layout>
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('update.user') }}">
                    @csrf
                    <x-success-message class="mb-4" :errors="$errors"></x-success-message>
                    <x-auth-validation-errors class="mb-4" :errors="$errors"></x-success-message>
                    <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="$users->id" />
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$users->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$users->email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Cambiar contra -->
                    <div class="mt-4">
                        <input type="checkbox" name="pregunta" value="si">Cambiar contraseña?</br>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"  autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Select Role -->
                    <div class="mt-4">
                        <x-input-label for="user_role" :value="__('Select Role')" />
                        <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="user_role" aria-label="Default select example" name="user_role" required="required">
                            <option value="1" @if ($users->rol == 1) selected @endif >Admin</option>
                            <option value="2" @if ($users->rol == 2) selected @endif>Supervisor</option>
                            <option value="3" @if ($users->rol == 3) selected @endif>Usuario</option>
                        </select>
                        <x-input-error :messages="$errors->get('user_role')" class="mt-2" />
                    </div>

                    <!-- Select Status -->
                    <div class="mt-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="status" aria-label="Default select example" name="status" required="required">
                            <option selected>Select Status...</option>
                            <option value="A" @if ($users->status == 'A') selected @endif >Alta</option>
                            <option value="B" @if ($users->status == 'B') selected @endif >Baja</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
</x-app-layout>