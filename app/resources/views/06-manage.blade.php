@extends('layout.base')

@section('content')
   Bienvenue {{ $rds->admin_first_name }} {{ $rds->admin_last_name }}
   <br>
   voir l'état des signatures : {{config('app.url'). '/state/' .$rds->url_two_hash}}
   <br>
   <a href="{{config('app.url'). '/download/' .$rds->url_three_hash}}">télécharger le pdf </a>
@endsection