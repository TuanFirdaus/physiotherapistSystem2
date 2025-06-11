<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('breadcrumbs'); ?>
<ul class="page-breadcrumb">
    <li class="nav-home">
        <a href="/adminDashboard" class="nav-link">
            <i class="icon-home"></i>
        </a>
    </li>

    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/viewAppointments">All Appointment</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/appointments/update/(:num)">Edit Appointment</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-5 mb-5">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">Edit Appointment</h4>
        </div>
        <div class="card-body p-4">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('appointments/update/' . $appointment['appointmentId']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?= esc($appointment['date']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="startTime" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="startTime" name="startTime" value="<?= esc($appointment['startTime']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="endTime" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="endTime" name="endTime" value="<?= esc($appointment['endTime']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="therapist_id" class="form-label">Therapist</label>
                    <select class="form-select" id="therapist_id" name="therapist_id" required>
                        <option value="">-- Select Therapist --</option>
                        <?php foreach ($therapists as $therapist): ?>
                            <option value="<?= $therapist['therapistId'] ?>" <?= $appointment['therapistId'] == $therapist['therapistId'] ? 'selected' : '' ?>>
                                <?= esc($therapist['therapistName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient</label>
                    <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?= esc($appointment['patientName']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Approved" <?= $appointment['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <div class="text-end">
                    <a href="<?= base_url('/viewAppointments') ?>" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>