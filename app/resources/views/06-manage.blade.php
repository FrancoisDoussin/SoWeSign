@extends('layout.base')

@section('content')
   Bienvenue {{ $rds->admin_first_name }} {{ $rds->admin_last_name }}
   <br>
   <a href="{{ config('app.url'). '/state/' .$rds->url_two_hash }}">voir l'état des signatures</a>
   <br>
   <a href="{{config('app.url'). '/download/' .$rds->url_three_hash}}">télécharger le pdf</a>
@endsection