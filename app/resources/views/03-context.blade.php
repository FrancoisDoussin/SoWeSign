@extends('layout.base')

@section('content')
    <h1 class="text-center">Tags liés au contexte</h1>

    <form action="{{ route('store-context') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <h2>#Meeting</h2>
        <div class="form-group">
            <input id="subject" class="form-control form-control-lg" name="subject" type="text" value="{{$meeting['subject'] or ''}}" placeholder="Sujet">
        </div>

        <div class="form-group">
            <textarea id="description" class="form-control form-control-lg" name="description" placeholder="Description">{{$meeting['description'] or ''}}</textarea>
        </div>

        <h2>#Schedule</h2>
        <div class="row">
            <div class="form-group col-6">
                <input id="date" class="form-control form-control-lg" name="date" type="date" value="{{$schedule['date'] or ''}}" data-toggle="tooltip" data-placement="top" title="Date de la réunion">
            </div>
            <div class="form-group col-6">
                <input id="time" class="form-control form-control-lg" name="time" type="time" value="{{$schedule['time'] or ''}}" data-toggle="tooltip" data-placement="top" title="Heure de la réunion">
            </div>
        </div>

        <div class="form-group">
            <input id="place" class="form-control form-control-lg" name="place" type="text" value="{{$schedule['place'] or ''}}" placeholder="Lieu de réunion">
        </div>
        <div class="form-group">
            <input id="url" class="form-control form-control-lg" name="url" type="text" value="{{$schedule['url'] or ''}}" placeholder="URL">
        </div>

        <div class="buttons">
            <button type="submit" class="btn btn-default">Suivant</button>
        </div>
    </form>
@endsection