<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        @if (Auth::user()->role == 'admin')
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MAIN</h4>
                </li>
                <li class="nav-item">
                    <a href="/">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/data-penghuni">
                        <i class="fas fa-users"></i>
                        <p>Data Penghuni</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/manage-rusun">
                        <i class="fas fa-building"></i>
                        <p>Data Rusun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/manage-kios">
                        <i class="fas fa-store"></i>
                        <p>Data Kios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/manage-mekanikal">
                        <i class="fas fa-wrench"></i>
                        <p>Data Mekanikal</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MASTER TRANSAKSI DAN KELUHAN</h4>
                </li>
                <li class="nav-item">
                    <a href="/sewa-rusun">
                        <i class="fas fa-file-contract"></i>
                        <p>Transaksi Sewa Rusun</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/sewa-kios">
                        <i class="fas fa-store-alt"></i>
                        <p>Transaksi Sewa Kios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/sewa-gedung">
                        <i class="fas fa-warehouse"></i>
                        <p>Transaksi Sewa Gedung</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/keluhan-admin">
                        <i class="fas fa-comment-dots"></i>
                        <p>Keluhan</p>
                    </a>
                </li>
            </ul>
        @else
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MAIN</h4>
                </li>
                <li class="nav-item">
                    <a href="/">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/tagihan-rusun-kios">
                        <i class="fas fa-file-contract"></i>
                        <p>Tagihan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/keluhan">
                        <i class="fas fa-comment-dots"></i>
                        <p>Ajukan Keluhan</p>
                    </a>
                </li>
            </ul>
        @endif
    </div>
</div>
