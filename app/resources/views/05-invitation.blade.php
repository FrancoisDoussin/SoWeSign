@extends('layout.base')

@section('content')
    <h1 class="text-center">Invitation</h1>

    <form action="{{ route('store-invitation') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <h2>#Sujet</h2>
        <div class="form-group">
            <input type="text" name="invitation_subject" id="invitation_subject" class="form-control form-control-lg"
                   placeholder="Sujet" value="{{$invitation['subject'] or ''}}">
        </div>

        <div class="form-group">
            <textarea name="invitation_description"
                      id="invitation_description" class="form-control form-control-lg" placeholder="Description">{{$invitation['description'] or ''}}</textarea>
        </div>

        <h2>#Relance</h2>
        <div class="row">
            <div class="form-group col-sm-4">
                <input type="number" name="invitation_quantity" id="invitation_quantity" class="form-control form-control-lg"
                       placeholder="Nombre de relances" value="{{$retry['quantity'] or ''}}">
            </div>
            <div class="form-group col-sm-4">
                <input type="number" name="invitation_delay" id="invitation_delay" class="form-control form-control-lg" value="{{$retry['delay'] or ''}}" placeholder="Délai d'envoi (jours)" >
            </div>
            <div class="form-group col-sm-4">
                <input type="number" name="invitation_frequency" id="invitation_frequency" class="form-control form-control-lg"
                       placeholder="Espacement des relances (jours)" value="{{$retry['frequency'] or ''}}">
            </div>
        </div>

        <div class="buttons">
            <button type="submit" class="btn btn-default">Valider</button>
        </div>
    </form>
@endsection