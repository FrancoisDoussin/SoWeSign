@extends('layout.base')

@section('content')
   {{config('app.url'). '/' .$rds->url_one_hash}}
   {{config('app.url'). '/' .$rds->url_two_hash}}
   {{config('app.url'). '/' .$rds->url_three_hash}}
@endsection