<a class="nav-item container-fluid" href="{{ route('claims') }}">
    <li class="nav-link text-white {{ request()->url() == route('claims') ? 'active' : '' }} row">
        <i class="fa fas fa-project-diagram pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">SAML Claims {{ request()->url() == route('claims') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>