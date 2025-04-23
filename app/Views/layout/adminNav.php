<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="white" style="box-shadow: 0px 8px 26px rgba(0, 0, 0, 0.2);">

        <a href="/adminDashboard" class="logo">
            <img
                src="assets2/assets/img/MAY3LOGO.png"
                alt="navbar brand"
                class="navbar-brand"
                height="100" />
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
                <a href="/adminDashboard">
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
                <div class="collapse" id="sidebarLayouts">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="/viewAppointments">
                                <span class="sub-item">All Appointment</span>
                            </a>
                        </li>
                        <li>
                            <a href="/approveApp">
                                <span class="sub-item">Pending Appointment</span>
                                <?php if (isset($pendingCount) && $pendingCount > 0): ?>
                                    <span class="badge bg-danger ms-2"><?= $pendingCount ?></span>
                                <?php endif; ?>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                    <i class="fas fa-address-book"></i>
                    <p>User Management</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="/manageTherapist">
                                <span class="sub-item">Therapist</span>
                            </a>
                        </li>
                        <li>
                            <a href="/managePatient">
                                <span class="sub-item">Patient</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                    <i class="fas fa-table"></i>
                    <p>Slot</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="/slotForm">
                                <span class="sub-item">Assign Slot</span>
                            </a>
                        </li>
                        <li>
                            <a href="/ManageSlot">
                                <span class="sub-item">Manage Slot</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>



<!-- End Navbar -->