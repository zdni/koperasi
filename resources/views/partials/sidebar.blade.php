<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a href="#" aria-expanded="true">
                        <span style="color: black">
                            {{ auth()->user()->name }}
                            <span class="user-level">{{ auth()->user()->role->name }}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ Request::is('beranda') ? 'active' : '' }}">
                    <a href="/beranda">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('karyawan', 'karyawan/*') ? 'active' : '' }}">
                    <a href="/karyawan">
                        <i class="fas fa-user-tie"></i>
                        <p>Karyawan</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('dana-jht', 'input-jht/*', 'detail-jht/*') ? 'active' : '' }}">
                    <a href="/dana-jht">
                        <i class="fas fa-credit-card"></i>
                        <p>Dana JHT</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('manajemen/*', 'kontrak-kerja', 'karyawan-nonaktif') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#setting">
                        <i class="fas fa-cog"></i>
                        <p>Data Master</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('manajemen/*', 'kontrak-kerja', 'karyawan-nonaktif') ? 'show' : '' }}" id="setting">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('manajemen/wilayah') ? 'active' : '' }}">
                                <a href="/manajemen/wilayah">
                                    <span class="sub-item">Wilayah</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('manajemen/unit') ? 'active' : '' }}">
                                <a href="/manajemen/unit">
                                    <span class="sub-item">Unit</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('manajemen/jabatan') ? 'active' : '' }}">
                                <a href="/manajemen/jabatan">
                                    <span class="sub-item">Jabatan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('manajemen/pengguna') ? 'active' : '' }}">
                                <a href="/manajemen/pengguna">
                                    <span class="sub-item">Pengguna</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('karyawan-nonaktif') ? 'active' : '' }}">
                                <a href="/karyawan-nonaktif">
                                    <span class="sub-item">Karyawan non Aktif</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>