<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    {{--<meta name="csrf-token" content="{{ \App\Providers\CSRFToken::generate_token() }}">--}}
    <title>@yield('title')</title>
    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{--<!-- Styles -->--}}
    {{--<link rel="stylesheet" href="{{ asset('/panel/plugin/nprogress/nprogress.css') }}">--}}
    {{--<!-- Bootstrap -->--}}
    <link href="../../panel/css/bootstrap.min.css" rel="stylesheet">
    {{--<!-- Font Awesome -->--}}
    {{--<link href="{{asset('/panel/plugin/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">--}}
    {{--<!-- NProgress -->--}}
    {{--<link href="{{asset('/panel/plugin/nprogress/nprogress.css')}}" rel="stylesheet">--}}
    {{--<!-- Custom Theme Style -->--}}
    {{--<link href="{{asset('/panel/plugin/build/css/custom.min.css')}}" rel="stylesheet">--}}
</head>
<body data-page-id="@yield('data-page-id')">
<div id="app">
    {{--<span>{{ getenv('APP_NAME') }}</span>--}}
        @yield('content')
</div>
{{--<!-- nprogress -->--}}
{{--<script src="{{asset('/panel/plugin/nprogress/nprogress.js')}}"></script>--}}
{{--<!-- jquery -->--}}
{{--<script src="{{asset('/panel/plugin/jquery/dist/jquery.min.js')}}"></script>--}}
{{--<script src="{{asset('/panel/js/plugin/jquery.min.js')}}"></script>--}}
{{--<!-- Bootstrap -->--}}
{{--<script src="{{asset('/panel/plugin/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>--}}
{{--<!-- FastClick -->--}}
{{--<script src="{{asset('/panel/plugin/fastclick/lib/fastclick.js')}}"></script>--}}
{{--<!-- NProgress -->--}}
{{--<script src="{{asset('/panel/plugin/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script>--}}
{{--<!-- custom -->--}}
{{--<script src="{{asset('/panel/plugin/build/js/custom.min.js')}}"></script>--}}
</body>
</html>
