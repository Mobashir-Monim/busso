<a class="nav-item container-fluid" href="{{ route('resource-groups') }}">
    <li class="nav-link text-white {{ request()->url() == route('resource-groups') ? 'active' : '' }} row">
        <i class="fa fas fa-layer-group pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Resource Group {{ request()->url() == route('resource-groups') ? '<span class="sr-only">(current)</span>' : '' }}</span>
    </li>
</a>