<x-app-layout>
<x-guest-layout>
    <form method="POST" action="{{ route('register.entrada') }}">
        @csrf

        <x-success-message class="mb-4" :errors="$errors"></x-success-message>

        <!-- Select Product -->
        <div class="mt-4">
        <x-input-label for="sl_product" :value="__('Producto')" />
            <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="sl_product" 
            aria-label="Default select example" name="sl_product" required="required">
            <option selected>Select product...</option>
            @foreach ($products as $item)
                <option value="{{ $item->id }}">{{ $item->Nombre }}</option>
            @endforeach
                
            </select>
            <x-input-error :messages="$errors->get('sl_product')" class="mt-2" />
        </div>

        <!-- Cantidad -->
        <div class="mt-4">
            <x-input-label for="cantidad" :value="__('Cantidad')" />
            <x-text-input id="cantidad" class="block mt-1 w-full" type="text" name="cantidad" :value="old('cantidad')" required autocomplete="cantidad" />
            <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
        </div>

        <!-- Total -->
        <div class="mt-4">
            <x-input-label for="total" :value="__('Total')" />
            <x-text-input id="total" class="block mt-1 w-full" type="text" name="total" :value="old('total')" required autocomplete="total" />
            <x-input-error :messages="$errors->get('total')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
</x-app-layout>