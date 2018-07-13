@extends('layout.base')

@section('content')
   @php
   $total_signatories = count($rds->signatories);
   $total_signs = 0;
   foreach ($rds->signatories as $signatory) {
      if($signatory->has_signed) {
      $total_signs++;
      }
   }
   @endphp
   <a href="{{config('app.url'). '/manage/' .$rds->url_one_hash}}" class="btn btn-tiny">retour</a>

   <p class="lead">{{ $total_signs }} signatures récoltées sur un total de {{ $total_signatories }}</p>

   <table class="table table-striped">
       <thead>
       <tr>
           <th>Nom</th>
           <th>Prénom</th>
           <th>email</th>
           <th>signature</th>
       </tr>
       </thead>
       <tbody>
       @foreach($rds->signatories as $signatory)
           <tr>
               <td>{{ $signatory->lastname }}</td>
               <td>{{ $signatory->firstname }}</td>
               <td>{{ $signatory->email }}</td>
               <td>@if($signatory->has_signed)<img src="{{ asset('storage/sign/' . $signatory->sign_name) }}" alt="signature" width="50px">@endif</td>
           </tr>
       @endforeach
       </tbody>
   </table>

@endsection