<x-app-layout>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">

                    <div class="card-body ">
                        <div class="table-responsive" style="height:350px;">
                        <table class="table">
                            <thead>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Existencias</th>
                                <th scope="col">Precio</th>
                                <th scope="col">PrecioCompra</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $key=>$item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="">{{ ++$key }}</td>
                                    <td class="">{{ $item->Nombre }}</td>
                                    <td class="">{{ $item->Existencias }}</td>
                                    <td class="">{{ $item->Precio }}</td>
                                    <td class="">{{ $item->PrecioCompra }}</td>
                                    <td class="">{{ $item->Codigo }}</td>
                                    @if($item->Status == 'A')
                                    <td class="">Disponible</td>
                                    @else
                                    <td class="">Baja</td>
                                    @endif
                                    <td class="">
                                        <form method="POST" action="{{ route('show.product', $item->id) }}">
                                            @csrf
                                            <div class="">
                                                <x-primary-button class="">
                                                    {{ __('Update') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="">
                                        <form method="POST" action="{{ route('showdel.product', $item->id) }}">
                                            @csrf
                                            <div class="">
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
            </div>
        </div>
    </div>
</x-app-layout>