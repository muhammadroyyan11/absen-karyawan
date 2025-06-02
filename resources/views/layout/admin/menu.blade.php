<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/img/sample/avatar/avatar1.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class=" {{ request()->is('panel-admin') ? 'active' : '' }}"><a href="/panel-admin"><i
                        class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class=" {{ request()->is('rekap-absen') ? 'active' : '' }}"><a href="/rekap-absen"><i
                        class="fa fa-briefcase"></i> <span>Rekap Absensi</span></a></li>

            <li class=" {{ request()->is('jadwal-input') ? 'active' : '' }}"><a href="/jadwal-input"><i
                        class="fa fa-calendar-plus-o"></i> <span>Input Jadwal</span></a></li>

            <li class=" {{ request()->is('admin/presensi-drive') ? 'active' : '' }}"><a href="/admin/presensi-drive"><i
                        class="fa fa-camera"></i> <span>Rekap Groaming</span></a></li>


            <li class="treeview {{ request()->is('request-cuti-list') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Cuti</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('request-cuti-list') ? 'active' : '' }}"><a href="/request-cuti-list"><i
                                class="fa fa-circle-o"></i> Permohonan Cuti</a></li>

                    <li class="{{ request()->is('history-cuti-list') ? 'active' : '' }}"><a href="/history-cuti-list"><i
                                class="fa fa-circle-o"></i> History Cuti</a></li>
                </ul>
            </li>
            <li class="header">OPERATION SETTING</li>
            <li class="{{ request()->is('shift') ? 'active' : '' }}">
                <a href="{{ route('shift.index') }}">
                    <i class="fa fa-clock-o"></i> <span>Shift</span>
                </a>
            </li>
            <li class=" {{ request()->is('data-users') ? 'active' : '' }}"><a href="/data-users"><i
                        class="fa fa-user"></i> <span>Denda</span></a></li>

            <li class="header">MASTER DATA</li>
            <li class="{{ request()->is('departments') ? 'active' : '' }}">
                <a href="{{ route('departments.index') }}">
                    <i class="fa fa-users"></i> <span>Data Divisi</span>
                </a>
            </li>
            <li class=" {{ request()->is('data-users') ? 'active' : '' }}"><a href="/data-users"><i
                        class="fa fa-user"></i> <span>Data Karyawan</span></a></li>
            <li class="{{ request()->is('departments') ? 'active' : '' }}">
                <a href="{{ route('departments.index') }}">
                    <i class="fa fa-address-card-o"></i> <span>Data Shift</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
