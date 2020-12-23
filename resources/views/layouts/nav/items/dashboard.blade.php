<a class="nav-item container-fluid" href="{{ route('home') }}">
    <li class="nav-link text-white {{ request()->url() == route('home') ? 'active' : '' }} row">
        <i class="fa fas fa-home pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Dashboard {{ request()->url() == route('home') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>