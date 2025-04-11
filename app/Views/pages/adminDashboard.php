<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>


<h2 class="text-center mb-4">Admin Dashboard</h2>

<!-- Overview Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text">50</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Appointments</h5>
                <p class="card-text">25 Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pending Payments</h5>
                <p class="card-text">5 Payments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Treatment Records</h5>
                <p class="card-text">40 Records</p>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Options -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <a href="/admin/users" class="btn btn-outline-primary w-100">Manage Users</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/appointments" class="btn btn-outline-success w-100">Manage Appointments</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/payments" class="btn btn-outline-warning w-100">Manage Payments</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="/admin/reports" class="btn btn-outline-info w-100">Generate Reports</a>
    </div>
</div>






<?= $this->endSection(); ?>