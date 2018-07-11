@extends('layout.base')

@section('content')
    <form action="{{ route('parse-pdf') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input name="pdf" type="file">
        <button type="submit">Télécharger</button>
    </form>
@endsection