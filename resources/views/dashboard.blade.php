<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        @foreach ($products as $item)
                        <div class="col-lg-3 col-4 col-md-3 mt-3">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset($item->Img)}}" alt="Card image cap" width="250px" height="250px">
                                <div class="card-body">
                                    <h5 class="card-title">{{$item->Nombre}}</h5>
                                    <p class="card-text">A solo ${{$item->Precio}} / Existencias {{$item->Existencias}}</p>
                                    <p class="card-text"><small class="text-muted">Código {{$item->Codigo}}</small></p>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-6 col-6 col-md-6">
                                                <form method="POST" action="{{ route('show.product', $item->id) }}">
                                                    @csrf
                                                    <input class="btn btn-primary bg-primary" type="submit" value="Editar">
                                                    <!-- <a href="#"  class="btn btn-primary">Editar</a> -->
                                                </form>
                                            </div>
                                            <div class="col-lg-6 col-6 col-md-6">
                                                <form method="POST" action="{{ route('showdel.product', $item->id) }}">
                                                    @csrf
                                                    <input class="btn btn-danger bg-danger" type="submit" value="Eliminar">
                                                    <!-- <a href="#" class="btn btn-danger">Eliminar</a> -->
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>