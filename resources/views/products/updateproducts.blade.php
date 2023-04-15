<x-app-layout>
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('update.product') }}">
                    @csrf

                    <x-success-message class="mb-4" :errors="$errors"></x-success-message>
                    
                    <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="$products->id" />

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="nombre" :value="__('Nombre')" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="$products->Nombre" required autofocus autocomplete="nombre" />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <!-- Existencias -->
                    <div class="mt-4">
                        <x-input-label for="existencia" :value="__('Existencia')" />
                        <x-text-input id="existencia" class="block mt-1 w-full" type="text" name="existencia" :value="$products->Existencias" required autocomplete="existencia" />
                        <x-input-error :messages="$errors->get('existencia')" class="mt-2" />
                    </div>

                    <!-- Precio -->
                    <div class="mt-4">
                        <x-input-label for="precio" :value="__('Precio')" />
                        <x-text-input id="precio" class="block mt-1 w-full" type="text" name="precio" :value="$products->Precio" required autocomplete="precio" />
                        <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                    </div>

                    <!-- Precio compra -->
                    <div class="mt-4">
                        <x-input-label for="precio_p" :value="__('Precio Compra')" />
                        <x-text-input id="precio_p" class="block mt-1 w-full" type="text" name="precio_p" :value="$products->PrecioCompra" required autocomplete="precio_p" />
                        <x-input-error :messages="$errors->get('precio_p')" class="mt-2" />
                    </div>

                    <!-- Codigo -->
                    <div class="mt-4">
                        <x-input-label for="codigo" :value="__('Código')" />
                        <x-text-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="$products->Codigo" required autocomplete="codigo" />
                        <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                    </div>

                    <!-- Select Product -->
                    <!-- <div class="mt-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="status" aria-label="Default select example" name="status" required="required">
                            <option selected>Select Status...</option>
                            <option value="A" @if ($products->Status == 'A') selected @endif>Disponible</option>
                            <option value="B" @if ($products->Status == 'B') selected @endif>Baja</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div> -->

                    @if(Auth::user()->rol == 3)
                        <!-- Codigo -->
                        <div class="mt-4">
                            <x-input-label for="codigo_v" :value="__('Código de Autorización')" />
                            <x-text-input id="codigo_v" class="block mt-1 w-full" type="text" name="codigo_v" />
                            <x-input-error :messages="$errors->get('codigo_v')" class="mt-2" />
                        </div>
                    @endif

                    <div class="mt-4">
                        <x-primary-button class="">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
</x-app-layout>