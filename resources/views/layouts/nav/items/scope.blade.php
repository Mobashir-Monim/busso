<a class="nav-item container-fluid" href="{{ route('scopes') }}">
    <li class="nav-link text-white {{ request()->url() == route('scopes') ? 'active' : '' }} row">
        <i class="fab fa-hive pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Oauth Scopes {{ request()->url() == route('scopes') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>