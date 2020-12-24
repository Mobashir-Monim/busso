<a class="nav-item container-fluid" href="{{ route('roles') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('roles')) ? 'active' : '' }} row">
        <i class="fas fa-exclamation-triangle pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Role {!! request()->url() == route('roles') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>