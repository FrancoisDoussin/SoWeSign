@extends('layout.base')

@section('content')
    <form action="{{ route('store-admin') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <label for="first-name">Prénom:</label>
        <input id="first-name" name="admin_first_name" type="text" value="{{$admin['firstname'] or ''}}">
        <label for="last-name">Nom:</label>
        <input id="last-name" name="admin_last_name" type="text" value="{{$admin['lastname'] or ''}}">
        <label for="email">Email:</label>
        <input id="email" name="admin_email" type="email" value="{{$admin['email'] or ''}}">
        <button type="submit">Envoyer</button>
    </form>
@endsection