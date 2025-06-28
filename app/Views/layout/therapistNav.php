<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="white" style="box-shadow: 0px 8px 26px rgba(0, 0, 0, 0.2); height: 11vh;">

        <a href="/therapistLogin" class="logo">
            <img
                src="<?= base_url('assets2/assets/img/MAY3LOGO.png') ?>"
                alt="navbar brand"
                class="navbar-brand" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item active">
                <a href="/therapistLogin">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                    <i class="fas fa-th-list"></i>
                    <p>Appointment</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="sidebarLayouts">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="<?= base_url('/treatment-records') ?>">
                                <span class="sub-item">My Patient</span>
                            </a>
                        </li>
                        <li>
                            <a href="/index/getCalendar">
                                <span class="sub-item">Schedule</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                    <i class="fas fa-address-book"></i>
                    <p>Patient Record</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="forms">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="/treatment">
                                <span class="sub-item">Add Treatment Records</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>



<!-- End Navbar -->