<!-- App Bottom Menu -->

<style>
    .submenu-overlay {
        position: absolute;
        bottom: 60px; /* posisi di atas tombol menu */
        left: 50%;
        transform: translateX(-50%);
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        padding: 16px;
        z-index: 999;
        min-width: 200px;
        text-align: left;
        font-size: 16px; /* Ukuran font */
    }

    .submenu-overlay a {
        display: block;
        font-weight: 500;
        padding: 10px 12px;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 12px; /* Jarak antar menu */
    }

    .submenu-overlay a:hover {
        background-color: #f0f0f0;
        color: #000;
    }

    .submenu-overlay a:last-child {
        margin-bottom: 0; /* Menghapus margin bawah pada item terakhir */
    }
</style>

<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Dashboard</strong>
        </div>
    </a>

    <div class="item position-relative">
        <div class="col text-center">
            <a href="#" onclick="toggleSubmenu(event)">
                <ion-icon name="calendar-outline"></ion-icon>
                <strong>Presensi</strong>
            </a>
        </div>

        <!-- Submenu Overlay -->
        <div id="submenu" class="submenu-overlay d-none">
            <a href="/history" class="{{ request()->is('history') ? 'text-primary fw-bold' : '' }}">
                Riwayat Presensi
            </a>
            <a href="/jadwal" class="{{ request()->is('history/jadwal') ? 'text-primary fw-bold' : '' }}">
                Jadwal Kerja
            </a>
            <a href="/history/rekap" class="{{ request()->is('history/rekap') ? 'text-primary fw-bold' : '' }}">
                Rekap Presensi
            </a>
        </div>
    </div>

    <a href="/presensi/create" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera"></ion-icon>
            </div>
        </div>
    </a>

    <a href="/presensi/cuti" class="item {{ request()->is('cuti') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>Cuti</strong>
        </div>
    </a>

    <a href="/edit-profile" class="item {{ request()->is('edit-profile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->

<script>
    // Fungsi untuk toggle submenu
    function toggleSubmenu(event) {
        event.preventDefault();  // Mencegah link default
        let submenu = document.getElementById('submenu');
        submenu.classList.toggle('d-none'); // Menambahkan/menghapus kelas d-none
    }

    // Optional: Close submenu when clicking outside
    document.addEventListener('click', function (event) {
        const submenu = document.getElementById('submenu');
        if (!event.target.closest('.item')) {
            submenu.classList.add('d-none');
        }
    });
</script>
