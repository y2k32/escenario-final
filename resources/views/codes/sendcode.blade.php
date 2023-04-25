<x-app-layout>
<x-guest-layout>
    <form method="POST" action="{{ route('send.code.email') }}">
        @csrf

        <x-success-message class="mb-4" :errors="$errors"></x-success-message>
        <!-- Select Usuario -->
        <div class="mt-4">
        <x-input-label for="sl_user" :value="__('Usuario')" />
            <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" id="sl_user" 
                aria-label="Default select example" name="sl_user" required="required">
                <option selected>Select user...</option>
                @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->email }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('sl_user')" class="mt-2" />
        </div>
        <!-- Código -->
        <div class="mt-4">
            <x-input-label for="codigo" :value="__('Código')" />
            <x-text-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="$codigo" required  readonly/>
            <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-primary-button class="">
                {{ __('Enviar Código por Correo') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
</x-app-layout>