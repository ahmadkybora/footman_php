@extends('layers.panel.content')
@section('title','dashboard')

@section('content')
    {{--<div class="container">--}}
        {{--<div class="jumbotron">--}}
            {{--<p>{{ \App\Providers\CSRFToken::generate_token() }}</p>--}}
            {{--<p>{{ csrf_token() }}</p>--}}
            {{--<p>{{ $_SERVER['REQUEST_URI'] }}</p>--}}
            {{--<p>{{ \App\Providers\Redirect::to('/') }}</p>--}}
        {{--</div>--}}
    {{--</div>--}}
    <br>
    <br>

    <div class="container">
        <div class="jumbotron">
            <form action="/admin/dashboard" method="POST" enctype="multipart/form-data">
                {{--{{ csrf_token() }}--}}
                <div class="form-group">
                    <input type="email" class="form-control" id="username" name="username" placeholder="Enter email">
                    </small>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop