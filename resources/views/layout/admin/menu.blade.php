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
            <li class=" {{ request()->is('panel-admin') ? 'active' : ''}}"><a href="/panel-admin"><i
                        class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class=" {{ request()->is('rekap-absen') ? 'active' : ''}}"><a href="/rekap-absen"><i
                        class="fa fa-dashboard"></i> <span>Rekap Absensi</span></a></li>

            <li class="treeview {{ request()->is('request-cuti-list') ? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Cuti</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('request-cuti-list') ? 'active' : ''}}"><a href="/request-cuti-list"><i class="fa fa-circle-o"></i> Permohonan Cuti</a></li>

                    <li class="{{ request()->is('history-cuti-list') ? 'active' : ''}}"><a href="/history-cuti-list"><i class="fa fa-circle-o"></i> History Cuti</a></li>
                </ul>
            </li>
            <li class="header">MASTER DATA</li>
            <li class=" {{ request()->is('data-users') ? 'active' : ''}}"><a href="/data-users"><i
                        class="fa fa-users"></i> <span>Data Karyawan</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
