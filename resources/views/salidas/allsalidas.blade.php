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
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($salidas as $key=>$item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">{{ ++$key }}</td>
                                        <td class="px-6 py-4">{{ $item->Nombre }}</td>
                                        <td class="px-6 py-4">{{ $item->Cantidad }}</td>
                                        <td class="px-6 py-4">{{ $item->Total }}</td>
                                        <td class="px-6 py-4">
                                            <form method="POST" action="{{ route('show.salida', ['id'=>$item->id,'idp'=>$item->Produc_id]) }}">
                                                @csrf
                                                <div class="">
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
            </div>
        </div>
    </div>
</x-app-layout>