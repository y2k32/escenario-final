<x-guest-layout>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <span class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Este es tu codigo QR de autenticación.</span>
            </label>
            <br><br>
            <p class="font-semibold text-x2 text-gray-800 dark:text-gray-200 leading-tight">Debes escanear este código con tu app de acceso movil.</p>
            <br>
        </div>
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        //Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher('9e043343a2db50ec828d', {
            cluster: 'us2'
        });
        var channel = pusher.subscribe('qr-readed');
        channel.bind('scanner', function(data) {
            let strData = JSON.stringify(data.user);
            let parseData = JSON.parse(strData);
            parseData.forEach(function(value,index){
                if(value.email == {!! json_encode($user) !!} ){
                    window.location.href = "{{ route('verificated_qr')}}";
                }
            })
        });
        
    </script>
        <div class="block mt-5" style="display: flex; justify-content: center;">
            <label for="remember_me" class="inline-flex items-center">
                <span class="font-semibold  text-gray-800 dark:text-gray-200 leading-tight" style="font-size: 50px;">{{ $qr_codeapp }}</span>
                
            </label>
            <br><br>
            <br><br>
        </div>
</x-guest-layout>