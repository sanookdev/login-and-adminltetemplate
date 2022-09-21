<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./" class="brand-link">
        <img src="<?= base_url('img/medlogopng.png');?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Biosafety System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3  d-flex">
            <div class="image mt-2">
                <img src="<?= base_url('img/user2-160x160.jpg');?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">USER : BET0047
                    <br>
                    <p style="font-size:0.75rem !important;font-style: italic;">STATUS : ADMIN</p>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= site_url('admin');?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= site_url('report');?>" class="nav-link">
                        <i class="far fa-list-alt nav-icon"></i>
                        <p>
                            โครงการทั้งหมด
                        </p>
                    </a>
                </li>
                <!-- เมนูตั้งค่า -->
                <li class="nav-item " style="border-bottom:1px solid #4f5962;">
                    <!-- <a href="#settings" class="nav-link " onclick="activityClassNavLink(this,'settings')"> -->
                    <a href="<?= site_url('setting');?>" class="nav-link ">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>
                            นำเข้าข้อมูล
                        </p>
                    </a>
                </li>
                <!-- เมนูตั้งค่า (end) -->

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>