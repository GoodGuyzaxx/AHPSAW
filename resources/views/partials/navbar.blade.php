<div class="nav-wrap">
    <button class="menu-btn" type="button" data-dropdown>Transaksi ▾</button>
    <div class="dropdown-panel">
        <div class="dd-grid">
            <a class="dd-item" href="#">
                <div>
                    <div class="dd-title">Pengajuan</div>
                    <div class="dd-desc">Input & verifikasi</div>
                </div>
            </a>
            <a class="dd-item" href="#">
                <div>
                    <div class="dd-title">Penilaian</div>
                    <div class="dd-desc">AHP/Skoring kriteria</div>
                </div>
            </a>
        </div>
    </div>
    </li>


    <li class="dropdown">
        <button class="menu-btn" type="button" data-dropdown>Laporan ▾</button>
        <div class="dropdown-panel">
            <div class="dd-grid">
                <a class="dd-item" href="#">
                    <div>
                        <div class="dd-title">Rekap</div>
                        <div class="dd-desc">Ekspor PDF/Excel</div>
                    </div>
                </a>
                <a class="dd-item" href="#">
                    <div>
                        <div class="dd-title">Aktivitas</div>
                        <div class="dd-desc">Audit trail</div>
                    </div>
                </a>
            </div>
        </div>
    </li>
    </ul>


    <div class="nav-actions">
        {{-- Optional: pencarian cepat --}}
        {{-- <form method="GET" action="{{ route('search') }}"> <input ...> </form> --}}


        <div class="profile-menu">
            <button class="menu-btn" type="button" data-dropdown>
<span class="avatar">
<img src="https://api.dicebear.com/7.x/initials/svg?seed={{ urlencode(Auth::user()->name ?? 'U') }}" alt="avatar" />
</span>
                <span>{{ Auth::user()->name ?? 'Pengguna' }}</span>
            </button>
            <div class="profile-panel">
                <a class="profile-item" href="#">Profil</a>
                <a class="profile-item" href="#">Ubah Password</a>
                <form class="profile-item" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:0;color:inherit;cursor:pointer">Keluar</button>
                </form>
            </div>
        </div>
    </div>
    </nav>
</div>
