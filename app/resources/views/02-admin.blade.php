@extends('layout.base')

@section('content')
    <h1 class="text-center">Bienvenue ADMIN</h1>
    <form action="{{ route('store-admin') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="form-group">
            <input id="first-name" class="form-control form-control-lg" name="admin_first_name" type="text" value="{{$admin['firstname'] or ''}}" placeholder="Prénom">
        </div>

        <div class="form-group">
            <input id="last-name" class="form-control form-control-lg" name="admin_last_name" type="text" value="{{$admin['lastname'] or ''}}" placeholder="Nom">
        </div>
        <div class="form-group">
            <input id="email" class="form-control form-control-lg" name="admin_email" type="email" value="{{$admin['email'] or ''}}" placeholder="Email">
        </div>
        <div class="buttons text-center">
            <a href="#" class="btn btn-danger mr-sm-5">Annuler</a>
            <button type="submit" class="btn btn-default ml-sm-5">Envoyer</button>
        </div>
    </form>
@endsection