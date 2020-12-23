<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            @include('layouts.nav.items.dashboard')
            @include('layouts.nav.items.access-log')
            
            @foreach ((new App\Helpers\ViewHelpers\NavBuilder)->getNavItems() as $item)
                @include('layouts.nav.items.' . $item)
            @endforeach

            @include('layouts.nav.items.logout')
        </ul>
    </div>
</nav>