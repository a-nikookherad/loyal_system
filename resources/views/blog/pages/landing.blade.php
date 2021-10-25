@extends("blog.layouts.main")
@push("header.styles")
    @dd(env("APP_URL").canonical($postInstance))
    <meta name="canonical" content="{{env("APP_URL")}}"
@endpush
@push("header.scripts")
@endpush
@section("content")
    <h1>this is blog landing</h1>
    <p>{!! $postInstance->content !!}</p>
    <button id="like" name="like" value="1">like</button>
    <button id="dislike" name="dislike" value="1">dislike</button>
@endsection
@push("footer.scripts")
    <script src="{{asset("assets/js/jquery-3.6.0.min.js")}}"></script>
    <script>
        $('#like').click(function () {
            $.ajax('api/v1/like',
                {
                    type: "POST",
                    data: {"comment_id": 1, "like": 1},
                    success: function (data, status, xhr) {    // success callback function
                        alert("success")
                        console.log("this is response data =======> ", data)
                    }
                });
        });
    </script>
@endpush


