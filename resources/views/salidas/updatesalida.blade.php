<x-app-layout>
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('update.salida') }}">
                    @csrf
                    <x-success-message class="mb-4" :errors="$errors"></x-success-message>
                    <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="$salida->id" />
                    <x-text-input id="idp" class="block mt-1 w-full" type="hidden" name="idp" :value="$products->id" />
                    <!-- Input Product -->
                    <div class="mt-4">
                        <x-input-label for="pnombre" :value="__('Producto')" />
                        <x-text-input id="pnombre" class="block mt-1 w-full" type="text" name="pnombre" :value="$products->Nombre" required readonly/>
                        <x-input-error :messages="$errors->get('pnombre')" class="mt-2" />
                    </div>

                    <!-- Cantidad -->
                    <div class="mt-4">
                        <x-input-label for="cantidad" :value="__('Cantidad')" />
                        <x-text-input id="cantidad" class="block mt-1 w-full" type="text" name="cantidad" :value="$salida->Cantidad" required autocomplete="cantidad" />
                        <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                    </div>

                    <!-- Total -->
                    <div class="mt-4">
                        <x-input-label for="total" :value="__('Total')" />
                        <x-text-input id="total" class="block mt-1 w-full" type="text" name="total" :value="$salida->Total" required autocomplete="total" />
                        <x-input-error :messages="$errors->get('total')" class="mt-2" />
                    </div>

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