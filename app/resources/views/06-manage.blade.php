@extends('layout.base')

@section('content')
   <h1>Bienvenue {{ $rds->admin_first_name }} {{ $rds->admin_last_name }}</h1>

   <h2>Etat des signatures</h2>
   <a href="{{config('app.url'). '/state/' .$rds->url_two_hash}}">{{config('app.url'). '/state/' .$rds->url_two_hash}}</a>
   <br><br><br>
   <h2>Télécharger le pdf</h2>
   <a href="{{config('app.url'). '/download/' .$rds->url_three_hash}}">{{config('app.url'). '/download/' .$rds->url_three_hash}}</a>
   <br><br><br>
   <h2>Lien pour les signataires</h2>
   <ul>
      @foreach($rds->signatories as $signatory)
         <li>
            {{$signatory->firstname}} {{$signatory->lastname}}
            <a href="{{config('app.url'). '/sign/' . $signatory->url_hash}}">{{config('app.url'). '/sign/' . $signatory->url_hash}}</a>
         </li>
      @endforeach
   </ul>
@endsection