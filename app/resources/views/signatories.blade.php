@extends('layout.base')

@section('content')
    @if(0 < $rds->signatories->count())
        <form action="{{ route('confirmation') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @foreach($rds->signatories as $signatory)
                <h2>Signataire {{$signatory->id}}</h2>
                <input hidden name="id-{{$signatory->id}}" type="number" value="{{$signatory->id}}">
                <label for="first-name-{{$signatory->id}}">Prénom</label>
                <input id="first-name-{{$signatory->id}}" name="first-name-{{$signatory->id}}" type="text" value="{{$signatory->first_name}}">
                <label for="last-name-{{$signatory->id}}">Nom</label>
                <input id="last-name-{{$signatory->id}}" name="last-name-{{$signatory->id}}" type="text" value="{{$signatory->last_name}}">
                <label for="company-{{$signatory->id}}">Entreprise</label>
                <input id="company-{{$signatory->id}}" name="company-{{$signatory->id}}" type="text" value="{{$signatory->company}}">
                <label for="email-{{$signatory->id}}">Email</label>
                <input id="email-{{$signatory->id}}" name="email-{{$signatory->id}}" type="email" value="{{$signatory->email}}">
            @endforeach
            <input hidden type="number" name="rds_id" value="{{$rds->id}}">
            <button type="submit">Download</button>
        </form>
    @else
        <p>Votre Pdf n'a pas de signature</p>
    @endif
@endsection