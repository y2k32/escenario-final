<x-app-layout>
<div class="container">
        <div class="row mt-4">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-body ">
                        <div class="table-responsive" style="height:350px;">
                            <table class="table">
                                <thead>
                                    <th scope="col" >#</th>
                                    <th scope="col" >Name</th>
                                    <th scope="col" >Email</th>
                                    <th scope="col" >Role</th>
                                    <th scope="col" >Accion</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key=>$item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">{{ ++$key }}</td>
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4">{{ $item->email }}</td>
                                        @if($item->rol == 1)
                                        <td class="px-6 py-4">Administrador</td>
                                        @endif
                                        @if($item->rol == 2)
                                        <td class="px-6 py-4">Supervisor</td>
                                        @endif
                                        @if($item->rol == 3)
                                        <td class="px-6 py-4">Usuario</td>
                                        @endif
                                        <td class="px-6 py-4">
                                            <form method="POST" action="{{ route('show.user', $item->id) }}">
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
    <!-- <div class="relative overflow-x-auto flex h-screen mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-auto pt-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Accion</th>
                        </tr>
                    </thead>
                        <tbody>
                        @php $n = 0 @endphp
                        @foreach ($users as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $n+=1 }}</td>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                @if($item->rol == 1)
                                <td class="px-6 py-4">Administrador</td>
                                @endif
                                @if($item->rol == 2)
                                <td class="px-6 py-4">Supervisor</td>
                                @endif
                                @if($item->rol == 3)
                                <td class="px-6 py-4">Usuario</td>
                                @endif
                                
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('show.user', $item->id) }}">
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
    </div> -->
</x-app-layout>