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

   {{ $total_signs }} signatures récoltées sur un total de {{ $total_signatories }}
   <br>

   <table>
      <tr>
         <th>Nom</th>
         <th>Prénom</th>
         <th>email</th>
         <th>signature</th>
      </tr>
      @foreach($rds->signatories as $signatory)
         <tr>
            <td>{{ $signatory->lastname }}</td>
            <td>{{ $signatory->firstname }}</td>
            <td>{{ $signatory->email }}</td>
            <td>@if($signatory->has_signed)<img src="{{ asset('storage/sign/' . $signatory->sign_name) }}" alt="">@endif</td>
         </tr>
      @endforeach
   </table>

@endsection