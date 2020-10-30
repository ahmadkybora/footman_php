@extends('layers.panel.content')
@section('title','categories')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop