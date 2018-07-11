@extends('layout.base')

@section('content')
    <form action="{{ route('store-invitation') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <h1>Invitation</h1>

        <label for="invitation_subject">Sujet</label>
        <input type="text" name="invitation_subject" id="invitation_subject" value="{{$invitation['subject'] or ''}}">

        <label for="invitation_description">Description</label>
        <textarea name="invitation_description" id="invitation_description">{{$invitation['description'] or ''}}</textarea>

        <label for="invitation_quantity">Nombre de relances</label>
        <input type="number" name="invitation_quantity" id="invitation_quantity" value="{{$retry['quantity'] or ''}}">

        <label for="invitation_delay">Délai d'envoi (jours)</label>
        <input type="number" name="invitation_delay" id="invitation_delay" value="{{$retry['delay'] or ''}}">

        <label for="invitation_frequency">Espacement des relances (jours)</label>
        <input type="number" name="invitation_frequency" id="invitation_frequency" value="{{$retry['frequency'] or ''}}">

        <button type="submit">Valider</button>
    </form>
@endsection