@extends('layout.base')

@section('content')
    <form action="{{ route('store-signatories') }}" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="nb_signatories" value="{{$nb_signatories}}">
        @csrf

        @for($i = 0; $i < $nb_signatories; $i++)
            @php($wanted_id = str_pad($i +1, 3, '0', STR_PAD_LEFT))
            <h2>Signataire {{$signatories[$i]['id'] or $wanted_id}}</h2>

            <input id="tag_number-{{$signatories[$i]['id'] or $wanted_id}}" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][tag_number]" type="text" value="{{$wanted_id}}">

            <label for="first-name-{{$signatories[$i]['id'] or $wanted_id}}">Prénom</label>
            <input id="first-name-{{$signatories[$i]['id'] or $wanted_id}}" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][firstname]" type="text" value="{{$signatories[$i]['firstname'] or ''}}">

            <label for="last-name-{{$signatories[$i]['id'] or $wanted_id}}">Nom</label>
            <input id="last-name-{{$signatories[$i]['id'] or $wanted_id}}" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][lastname]" type="text" value="{{$signatories[$i]['lastname'] or ''}}">

            <label for="company-{{$signatories[$i]['id'] or $wanted_id}}">Entreprise</label>
            <input id="company-{{$signatories[$i]['id'] or $wanted_id}}" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][company]" type="text" value="{{$signatories[$i]['company'] or ''}}">

            <label for="email-{{$signatories[$i]['id'] or $wanted_id}}">Email</label>
            <input id="email-{{$signatories[$i]['id'] or $wanted_id}}" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][email]" type="text" value="{{$signatories[$i]['email'] or ''}}">
        @endfor
        <button type="submit">Valider</button>
    </form>
@endsection