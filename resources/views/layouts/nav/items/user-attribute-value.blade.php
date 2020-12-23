<a class="nav-item container-fluid" href="{{ route('user-attribute-values') }}">
    <li class="nav-link text-white {{ request()->url() == route('user-attribute-values') ? 'active' : '' }} row">
        <i class="fas fa-braille pr-1 col-2 my-auto"></i><span class="d-inline-block col-10"></i>User Attribute Values {{ request()->url() == route('user-attribute-values') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>