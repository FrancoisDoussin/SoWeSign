@extends('layout.base')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-10">
            <h1>SoWeSign blablabla blablablablablabla</h1>
            <p>
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos
                qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
                Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid
                ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil
                molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
            </p>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-10">
            <form action="{{ route('create-admin') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group">
                    <input type="file" name="file" class="form-control-file">
                </div>
                <button type="submit">Continuer</button>
            </form>
        </div>
    </div>
@endsection