<!-- Modern Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary shadow-lg sticky-top">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('dashboard.index') }}">
            <img src="{{ url('frontend/images/logo.png') }}" style="height: 45px; width: 45px;" alt="SPK" class="me-2 rounded-circle shadow-sm" />
            <span class="text-white">SI-SPK</span>
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active bg-white bg-opacity-20 rounded' : '' }} px-3 py-2 mx-1 transition-all"
                       href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>

                <!-- Master Data Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('dashboard/kriteria*') || Request::is('dashboard/student*') || Request::is('dashboard/alternatif*') ? 'active bg-white bg-opacity-20 rounded' : '' }} px-3 py-2 mx-1"
                       href="#" id="masterDataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-database me-2"></i>Master Data
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3" aria-labelledby="masterDataDropdown">
                        @can('admin')
                            <li>
                                <a class="dropdown-item py-2 {{ Request::is('dashboard/kriteria*') ? 'active' : '' }}"
                                   href="{{ route('kriteria.index') }}">
                                    <i class="fas fa-table-columns me-2 text-primary"></i>Data Kriteria
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 {{ Request::is('dashboard/student*') ? 'active' : '' }}"
                                   href="{{ route('student.index') }}">
                                    <i class="fas fa-school me-2 text-success"></i>Data Mahasiswa
                                </a>
                            </li>
                        @endcan
                        <li>
                            <a class="dropdown-item py-2 {{ Request::is('dashboard/alternatif*') ? 'active' : '' }}"
                               href="{{ route('alternatif.index') }}">
                                <i class="fas fa-users-rectangle me-2 text-info"></i>Data Alternatif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Analisis Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('dashboard/perbandingan*') || Request::is('dashboard/ranking*') ? 'active bg-white bg-opacity-20 rounded' : '' }} px-3 py-2 mx-1"
                       href="#" id="analisisDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-line me-2"></i>Analisis
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3" aria-labelledby="analisisDropdown">
                        <li>
                            <a class="dropdown-item py-2 {{ Request::is('dashboard/perbandingan*') ? 'active' : '' }}"
                               href="{{ route('perbandingan.index') }}">
                                <i class="fas fa-code-compare me-2 text-warning"></i>Perbandingan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 {{ Request::is('dashboard/ranking*') ? 'active' : '' }}"
                               href="{{ route('rank.index') }}">
                                <i class="fas fa-ranking-star me-2 text-danger"></i>Perangkingan
                            </a>
                        </li>
                    </ul>
                </li>

                @can('admin')
                    <!-- User Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard/users*') ? 'active bg-white bg-opacity-20 rounded' : '' }} px-3 py-2 mx-1"
                           href="{{ route('users.index') }}">
                            <i class="fas fa-user-gear me-2"></i>Pengguna
                        </a>
                    </li>
                @endcan
            </ul>

            <!-- Right side - User info and logout -->
            <div class="d-flex align-items-center">
                <!-- Welcome message -->
                <span class="text-white me-3 d-none d-md-block">
                    <small>Selamat datang, <strong>{{ auth()->user()->name }}</strong></small>
                </span>

                <!-- User dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm rounded-pill dropdown-toggle border-2"
                            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="d-none d-sm-inline">{{ auth()->user()->level }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item py-2 {{ Request::is('dashboard/profile*') ? 'active' : '' }}"
                               href="{{ route('profile.index') }}">
                                <i class="fas fa-user-pen me-2 text-primary"></i>Ubah Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="dropdown-item py-2 text-danger btnLogout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
