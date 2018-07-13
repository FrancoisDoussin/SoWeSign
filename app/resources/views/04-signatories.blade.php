@extends('layout.base')

@section('content')
    <h1 class="text-center">Liste des {{$nb_signatories}} signataires</h1>

    <form action="{{ route('store-signatories') }}" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="nb_signatories" value="{{$nb_signatories}}">
        @csrf

        @for($i = 0; $i < $nb_signatories; $i++)
            @php($wanted_id = str_pad($i +1, 3, '0', STR_PAD_LEFT))
            <div id="accordion">
                <div class="accordion__header" id="signatoriesList">
                    <h2>
                        <a class="btn btn-accordion" data-toggle="collapse" data-target="#signatoriesData_{{$i}}" aria-expanded="true" aria-controls="signatoriesData">
                            Signataire {{$signatories[$i]['id'] or $wanted_id}}
                        </a>
                    </h2>
                </div>

                <div id="signatoriesData_{{$i}}" class="collapse show" aria-labelledby="signatoriesList" data-parent="#accordion">
                    <div class="accordion__body">
                        <input id="tag_number-{{$signatories[$i]['id'] or $wanted_id}}" class="form-control form-control-lg" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][tag_number]" type="hidden" value="{{$wanted_id}}">

                        <div class="form-group">
                            <input id="first-name-{{$signatories[$i]['id'] or $wanted_id}}" class="form-control form-control-lg" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][firstname]" type="text" value="{{$signatories[$i]['firstname'] or ''}}" placeholder="Prénom">
                        </div>
                        <div class="form-group">
                            <input id="last-name-{{$signatories[$i]['id'] or $wanted_id}}" class="form-control form-control-lg" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][lastname]" type="text" value="{{$signatories[$i]['lastname'] or ''}}" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <input id="company-{{$signatories[$i]['id'] or $wanted_id}}" class="form-control form-control-lg" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][company]" type="text" value="{{$signatories[$i]['company'] or ''}}" placeholder="Entreprise">
                        </div>

                        <div class="form-group">
                            <input id="email-{{$signatories[$i]['id'] or $wanted_id}}" class="form-control form-control-lg" name="signatories[{{$signatories[$i]['id'] or $wanted_id}}][email]" type="text" value="{{$signatories[$i]['email'] or ''}}" placeholder="Email">
                        </div>
                    </div>
                </div>
            </div>
        @endfor
        <div class="buttons">
            <a href="#" class="btn btn-danger mr-sm-5">Annuler</a>
            <button type="submit" class="btn btn-default ml-sm-5">Valider</button>
        </div>
    </form>
@endsection