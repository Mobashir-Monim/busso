<span class="nav-item container-fluid d-md-none">
    <li class="nav-link text-white row">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <i class="fas fa-power-off pr-1 col-2 my-auto"></i><span class="d-inline-block col-10">Logout</span>
        </form>
    </li>
</span>