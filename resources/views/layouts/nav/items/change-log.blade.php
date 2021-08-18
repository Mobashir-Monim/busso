<a class="nav-item container-fluid" href="{{ route('change-log') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('change-log')) ? 'active' : '' }} row">
        <i class="fa fas fa-dice-d20 pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Change Log {!! request()->url() == route('change-log') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>