<x-app-layout>
<div class="relative overflow-x-auto flex h-screen mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-auto pt-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Producto</th>
                            <th scope="col" class="px-6 py-3">Cantidad</th>
                            <th scope="col" class="px-6 py-3">Total</th>
                            <th scope="col" class="px-6 py-3">Accion</th>
                        </tr>
                    </thead>
                        <tbody>
                        @php $n = 0 @endphp
                        @foreach ($entradas as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $n+=1 }}</td>
                                <td class="px-6 py-4">{{ $item->Produc_id }}</td>
                                <td class="px-6 py-4">{{ $item->Cantidad }}</td>
                                <td class="px-6 py-4">{{ $item->Total }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('show.entrada', $item->id) }}">
                                        @csrf
                                        <div class="mt-4">
                                            <x-primary-button class="">
                                                {{ __('Update') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>