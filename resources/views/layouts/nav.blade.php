<header class="navbar navbar-expand-md navbar-overlap d-print-none" data-bs-theme="dark">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <img src="{{ asset('template') }}/static/logo.svg" width="110" height="32" alt="Tabler"
                    class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav d-flex justify-content-between align-items-center order-md-last">
            <div class="col-auto">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ asset('template') }}/static/avatars/000m.jpg)"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="mt-1 small text-muted">{{ Auth::user()->role->name }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="./settings.html" class="dropdown-item">Settings</a>
                        <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
                        <form id="logout-form"  action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <i class="bi bi-house-door"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown  {{ request()->routeIs(['kriteria.*', 'alternatif.*']) ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <i class="bi bi-book"></i>
                            &nbsp;
                            <span class="nav-link-title">
                               Master
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item {{ request()->routeIs('alternatif*') ? 'active' : '' }}" href="{{ route('alternatif.index') }}">
                                        Alternatif
                                    </a>

                                    <a class="dropdown-item {{ request()->routeIs('kriteria*') ? 'active' : '' }}" href="{{ route('kriteria.index') }}">
                                        Kriteria
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- <li class="nav-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kriteria.index') }}">
                            <i class="bi bi-card-list"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Kriteria
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('alternatif.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('alternatif.index') }}">
                            <i class="bi bi-people"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Alternatif
                            </span>
                        </a>
                    </li> --}}
                    <li class="nav-item {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('penilaian.index') }}">
                            <i class="bi bi-bookshelf"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Penilaian
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('normalisasi.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('normalisasi.index') }}">
                            <i class="bi bi-archive"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Normalisasi
                            </span>
                        </a>
                    </li>
                    @canany(['view-role', 'view-user'])
                    <li class="nav-item dropdown  {{ request()->routeIs(['user.*', 'role.*']) ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <i class="bi bi-gear"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Access Management
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    @can('view-user')
                                    <a class="dropdown-item {{ request()->routeIs('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                        User
                                    </a>
                                    @endcan
                                    @can('view-role')
                                    <a class="dropdown-item {{ request()->routeIs('role*') ? 'active' : '' }}" href="{{ route('role.index') }}">
                                        Role
                                    </a>
                                    @endcan

                                </div>
                            </div>
                        </div>
                    </li>
                    @endcanany
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <i class="bi bi-book"></i>
                            &nbsp;
                            <span class="nav-link-title">
                                Master
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item "
                                        href="">
                                        Recipient
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li> --}}

                </ul>
            </div>
        </div>
    </div>
</header>
