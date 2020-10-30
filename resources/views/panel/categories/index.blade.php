@extends('layers.panel.content')
@section('title','categories')
@section('data-page-id','categories')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>categories</h1>
            {{--@if($message)--}}
                {{--<p>{{ $message }}</p>--}}
            {{--@endif--}}
            {{--@include('errors.messages')--}}
            <form action="/admin/product/categories/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <br>
            <br>
            <table class="table table-striped table-bordered table-hover">
                <thead class="text-center">
                <tr>
                    <td>number</td>
                    <td>name</td>
                    <td>slug</td>
                    <td>created_at</td>
                    <td>options</td>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($categories as $count=>$category)
                <tr>
                    <td>{{ $count ++ }}</td>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ $category['slug'] }}</td>
                    <td>{{ $category['created_at'] }}</td>
                    <td>
                        <a href="" class="btn btn-primary">Show</a>
                        <a href="{{ $category['id'] }}" class="btn btn-success">Edit</a>
                        <form>
                            <input type="hidden" name="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $category['id'] }}" placeholder="Enter Name">
                            </div>
                            <button type="submit" class="btn btn-primary" id="{{ $category['id'] }}">update</button>
                        </form>
                        <a href="" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {!! $links !!}
        </div>
    </div>
@stop