@extends('layout.base')

@section('content')
    <form action="{{ route('signatories') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <label for="name">Meeting:</label>
        <input id="name" name="name" type="text"  @if (isset($rds->name))value="{{$rds->name}}" @endif>
        <label for="date">Schedule:</label>
        <input id="date" name="date" type="date"  @if (isset($rds->date))value="{{$rds->date}}" @endif>
        <input hidden type="number" name="rds_id" value="{{$rds->id}}">
        <button type="submit">Suivant</button>
    </form>
@endsection