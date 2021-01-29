<a class="nav-item container-fluid" href="{{ route('users.access-log') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('users.access-log')) ? 'active' : '' }} row">
        <i class="fa fas fa-clipboard-list pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Access Log {!! request()->url() == route('users.access-log') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>