<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoWeSign</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>
    @yield('styles')
</head>
<body>
    @include('layout.navbar')
    <div class="container">
        {{--Session errors--}}
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif

        {{--Form errors--}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="section">
            @yield('content')
        </div>
    </div>
    @include('layout.footer')
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    @yield('script')
</body>
</html>
