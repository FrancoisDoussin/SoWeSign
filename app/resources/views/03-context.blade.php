@extends('layout.base')

@section('content')
    <form action="{{ route('store-context') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <h3>Meeting</h3>
        <label for="subject">Subject:</label>
        <input id="subject" name="subject" type="text" value="{{$meeting['subject'] or ''}}">

        <label for="description">Description:</label>
        <textarea id="description" name="description">{{$meeting['description'] or ''}}</textarea>

        <h3>Schedule</h3>
        <label for="date">Date:</label>
        <input id="date" name="date" type="date" value="{{$schedule['date'] or ''}}">

        <label for="time">Time:</label>
        <input id="time" name="time" type="time" value="{{$schedule['time'] or ''}}">

        <label for="place">Place:</label>
        <input id="place" name="place" type="text" value="{{$schedule['place'] or ''}}">

        <label for="url">Url:</label>
        <input id="url" name="url" type="text" value="{{$schedule['url'] or ''}}">

        <button type="submit">Suivant</button>
    </form>
@endsection