@extends("layouts.main")
@push("header_styles")
    <styel>

    </styel>
@endpush
@push("header_scripts")
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('352dee5a9be0a52df8ec', {
            cluster: 'eu'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('User-register-event', function(data) {
            $("#h1").html(JSON.stringify(data))
        });
    </script>
@endpush
@section("content")
    <h1 id="h1">hello and welcome</h1>
@endsection
