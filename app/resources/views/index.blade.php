@extends('layout.base')

@section('content')
    <form action="{{ route('create-admin') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input name="file" type="file">
        <button type="submit">Télécharger</button>
    </form>
@endsection