<x-app-layout>
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('register.product') }}">
                    @csrf

                    <x-success-message class="mb-4" :errors="$errors"></x-success-message>

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="nombre" :value="__('Nombre')" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <!-- Existencias -->
                    <div class="mt-4">
                        <x-input-label for="existencia" :value="__('Existencia')" />
                        <x-text-input id="existencia" class="block mt-1 w-full" type="text" name="existencia" :value="old('existencia')" required autocomplete="existencia" />
                        <x-input-error :messages="$errors->get('existencia')" class="mt-2" />
                    </div>

                    <!-- Precio -->
                    <div class="mt-4">
                        <x-input-label for="precio" :value="__('Precio')" />
                        <x-text-input id="precio" class="block mt-1 w-full" type="text" name="precio" :value="old('precio')" required autocomplete="precio" />
                        <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                    </div>

                    <!-- Precio compra -->
                    <div class="mt-4">
                        <x-input-label for="precio_p" :value="__('Precio Compra')" />
                        <x-text-input id="precio_p" class="block mt-1 w-full" type="text" name="precio_p" :value="old('precio_p')" required autocomplete="precio_p" />
                        <x-input-error :messages="$errors->get('precio_p')" class="mt-2" />
                    </div>

                    <!-- Codigo -->
                    <div class="mt-4">
                        <x-input-label for="codigo" :value="__('Código')" />
                        <x-text-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="old('codigo')" required autocomplete="codigo" />
                        <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button class="">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
</x-app-layout>