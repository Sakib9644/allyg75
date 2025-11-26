@php
    use Illuminate\Support\Facades\Route;
@endphp
<!--APP-SIDEBAR-->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar" style="overflow: scroll">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset(settings('logo') ?? 'default/logo.svg') }}" id="header-brand-logo" alt="logo"
                    width="{{ settings('logo_width') ?? 67 }}" height="{{ settings('logo_height') ?? 67 }}">
                </a>
        </div>
        <div class="main-sidemenu">
            <input class="form-control form-control-dark w-100 border-0" id="menuSearching" type="text"
                placeholder="Search" aria-label="Search">
            <ul id="customMenulist" class="side-menu"></ul>
        </div>
        <div class="main-sidemenu">
            <ul class="side-menu mt-2">
                <li>
                    <h3>Menu</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('dashboard') ? 'has-link active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-house side-menu__icon"></i>
                        <span class=" side-menu__label">Dashboard</span>
                    </a>
                </li>

                <li>
                    <h3>Basic</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.category.*') ? 'has-link active' : '' }}"
                        href="{{ route('admin.category.index') }}">
                        <i class="fa-solid fa-layer-group side-menu__icon"></i>
                        <span class="side-menu__label">Category</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.event.*') ? 'has-link active' : '' }}"
                        href="{{ route('admin.event.index') }}">
                        <i class="fa-solid fa-calendar-days side-menu__icon"></i>
                        <span class="side-menu__label">Events</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.locations.*') ? 'has-link active' : '' }}"
                        href="{{ route('admin.locations.index') }}">
                        <i class="fa-solid fa-map-marker-alt side-menu__icon"></i>
                        <span class="side-menu__label">Locations</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.mystories.*') ? 'has-link active' : '' }}"
                        href="{{ route('admin.mystories.index') }}">
                        <i class="fa-solid fa-book side-menu__icon"></i>
                        <span class="side-menu__label">My Stories</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.chat.*') ? 'has-link active' : '' }}"
                        href="{{ route('admin.chat.index') }}">
                        <i class="fa-brands fa-rocketchat side-menu__icon"></i>
                        <span class="side-menu__label">Chat</span>
                    </a>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>
<!--/APP-SIDEBAR-->

<script>
    const menuSearchInput = document.getElementById('menuSearching');
    const customMenuList = document.getElementById('customMenulist');
    const menus = @json(App\Models\Menu::where('status', 1)->orderBy('id', 'DESC')->get());

    function sideMenu() {
        menus.forEach(menu => {
            if (menu.name.toLowerCase().includes(menuSearchInput.value.toLowerCase())) {
                customMenuList.innerHTML += `
                    <li class="slide">
                        <a class="side-menu__item" href="#">
                            <i class="fa-solid fa-bars side-menu__icon"></i>
                            <span class="side-menu__label">${menu.name}</span>
                        </a>
                    </li>
                `;
            }
        });
    }

    menuSearchInput.addEventListener('input', function() {
        customMenuList.innerHTML = '';
        if (menuSearchInput.value.trim() === '') {
            customMenuList.innerHTML = '';
        } else {
            sideMenu();
        }
    });
</script>
