<?= $this->extend('layout/therapistTemp'); ?>

<?= $this->section('content'); ?>

<h2 class="text-center mb-4">Admin Dashboard</h2>

<div class="container mt-4">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-user-md fa-3x me-3"></i>
                    <div>
                        <h4 class="mb-1">Welcome, Master <?= esc($user['name']) ?>!</h4>
                        <p class="mb-0">Here’s your therapist dashboard. Manage your appointments, profile, and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Info Cards -->
    <div class="row g-4">
        <!-- Today's Appointments -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-calendar-check text-success me-2"></i>Today's Appointments</h5>
                    <p class="display-6"><?= esc($todayAppointments ?? 0) ?></p>
                    <a href="<?= base_url('therapist/appointments') ?>" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
            </div>
        </div>
        <!-- Upcoming Appointments -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-clock text-warning me-2"></i>Upcoming Appointments</h5>
                    <p class="display-6"><?= esc($upcomingAppointments ?? 0) ?></p>
                    <a href="<?= base_url('therapist/appointments?filter=upcoming') ?>" class="btn btn-outline-primary btn-sm">See Schedule</a>
                </div>
            </div>
        </div>
        <!-- Profile Quick Access -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-edit text-info me-2"></i>Edit Profile</h5>
                    <p class="mb-2">Update your contact info, expertise, and profile picture.</p>
                    <a href="<?= base_url('therapist/profile') ?>" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle text-secondary me-2"></i>Information</h5>
                    <ul class="mb-0">
                        <li>Check your appointments and manage your schedule.</li>
                        <li>Update your availability and expertise in your profile.</li>
                        <li>Contact admin for support or questions.</li>
                        <!-- Add or edit more info as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>