@extends('layout.base')

@section('content')
    <form action="{{ route('context') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <label for="first-name">Prénom:</label>
        <input id="first-name" name="admin_first_name" type="text" @if (isset($rds->admin_first_name))value="{{$rds->admin_first_name}}" @endif>
        <label for="last-name">Nom:</label>
        <input id="last-name" name="admin_last_name" type="text" @if (isset($rds->admin_last_name))value="{{$rds->admin_first_name}}" @endif>
        <label for="email">Email:</label>
        <input id="email" name="admin_email" type="email" @if (isset($rds->admin_email))value="{{$rds->admin_email}}" @endif>
        <input hidden type="number" name="rds_id" value="{{$rds->id}}">
        <button type="submit">Envoyer</button>
    </form>
@endsection