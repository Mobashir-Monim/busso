<a class="nav-item container-fluid" href="{{ route('users') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('users')) ? 'active' : '' }} row">
        <i class="fas fa-user pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Users {!! request()->url() == route('users') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>