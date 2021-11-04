<a class="nav-item container-fluid" href="{{ route('debugger') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('debugger')) ? 'active' : '' }} row">
        <i class="fa fas fa-bug pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Debugger {!! request()->url() == route('debugger') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>