<x-app-layout>
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('update.entrada') }}">
                    @csrf
                    <x-success-message class="mb-4" :errors="$errors"></x-success-message>
                    <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="$entradas->id" />

                    <!-- Select Product -->
                    <div class="mt-4">
                        <x-input-label for="sl_product" :value="__('Producto')" />
                        <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="sl_product" aria-label="Default select example" name="sl_product" required="required">
                            @foreach ($products as $item)
                                @if($item->id == $entradas->id)
                                    <option value="{{ $item->id }}" selected>{{ $item->Nombre }}</option>
                                @endif
                                <option value="{{ $item->id }}">{{ $item->Nombre }}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('sl_product')" class="mt-2" />
                    </div>

                    <!-- Cantidad -->
                    <div class="mt-4">
                        <x-input-label for="cantidad" :value="__('Cantidad')" />
                        <x-text-input id="cantidad" class="block mt-1 w-full" type="text" name="cantidad" :value="$entradas->Cantidad" required autocomplete="cantidad" />
                        <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                    </div>

                    <!-- Total -->
                    <div class="mt-4">
                        <x-input-label for="total" :value="__('Total')" />
                        <x-text-input id="total" class="block mt-1 w-full" type="text" name="total" :value="$entradas->Total" required autocomplete="total" />
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