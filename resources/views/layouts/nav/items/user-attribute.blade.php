<a class="nav-item container-fluid" href="{{ route('user-attributes') }}">
    <li class="nav-link text-white {{ request()->url() == route('user-attributes') ? 'active' : '' }} row">
        <i class="fab fa-creative-commons-by pr-1 col-2 my-auto"></i><span class="d-inline-block col-10"></i>User Attributes {{ request()->url() == route('user-attributes') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>
