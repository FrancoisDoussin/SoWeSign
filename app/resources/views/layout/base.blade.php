<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoWeSign</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    {{--<link rel="stylesheet" href="{{asset('storage/css/signature-pad.css')}}">--}}
</head>
<body>
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

        @yield('content')
    </div>
</body>
</html>
