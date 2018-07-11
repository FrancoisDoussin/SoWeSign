<nav class="navbar navbar-expand-sm navbar-light sticky-top">
    <a class="navbar-brand-mobile" href="{{ route('index') }}">
        <img src="{{asset('img/logo-sowesign.png')}}"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto d-flex align-items-center">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    Fonctionnalités
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Tarifs
                </a>
            </li>
        </ul>

        <div>
            <a class="navbar-brand mx-auto" href="{{ route('index') }}">
                <img src="{{asset('img/logo-sowesign.png')}}"/>
            </a>
        </div>

        <ul class="navbar-nav mx-auto d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Plus d’infos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        Qui sommes nous ?
                    </a>
                    <a class="dropdown-item" href="#">
                        Presse
                    </a>
                    <a class="dropdown-item" href="#">
                        Blog
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown border-0">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    FR
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        GB
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>