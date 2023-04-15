<x-app-layout>
<div class="relative overflow-x-auto flex h-screen mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-auto pt-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Existencias</th>
                            <th scope="col" class="px-6 py-3">Precio</th>
                            <th scope="col" class="px-6 py-3">PrecioCompra</th>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $n = 0 @endphp
                        @foreach ($products as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $n+1 }}</td>
                            <td class="px-6 py-4">{{ $item->Nombre }}</td>
                            <td class="px-6 py-4">{{ $item->Existencias }}</td>
                            <td class="px-6 py-4">{{ $item->Precio }}</td>
                            <td class="px-6 py-4">{{ $item->PrecioCompra }}</td>
                            <td class="px-6 py-4">{{ $item->Codigo }}</td>
                            @if($item->Status == 'A')
                            <td class="px-6 py-4">Disponible</td>
                            @else
                            <td class="px-6 py-4">Baja</td>
                            @endif
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('show.product', $item->id) }}">
                                    @csrf
                                    <div class="mt-4">
                                        <x-primary-button class="">
                                            {{ __('Update') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('showdel.product', $item->id) }}">
                                    @csrf
                                    <div class="mt-4">
                                        <x-primary-button class="">
                                            {{ __('Delete') }}
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