@extends("blog.layouts.main")
@section("content")
    <h1>this is blog landing</h1>
    <button id="like" name="like" value="1">like</button>
    <button id="dislike" name="dislike" value="1">dislike</button>
@endsection
@push("footer.js")
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


