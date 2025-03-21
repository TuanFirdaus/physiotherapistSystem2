<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5" style="min-height: 100vh;">
    <h2 class="text-center mb-4">List Appointment</h2>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Appointment Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Treatment Name</th>
                <th>Phone Number</th>
                <th>Treatment Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= esc($appointment['patientName']) ?></td>
                    <td><?= esc($appointment['treatmentName']) ?></td>
                    <td><?= esc($appointment['patientPhoneNum']) ?></td>
                    <td><?= esc($appointment['treatmentPrice']) ?></td>
                    <td><?= esc($appointment['status']) ?></td>
                    <td>
                        <div class="form-button-action">
                            <form action="/appointments/approve/<?= esc($appointment['appointmentId']) ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="status" value="<?= esc($appointment['status']) ?>">
                                <button type="submit" data-bs-toggle="tooltip" title="Approve Booking" class="btn btn-link btn-primary btn-lg">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                            <form action="/appointments/delete/<?= esc($appointment['appointmentId']) ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" data-bs-toggle="tooltip" title="Delete Booking" class="btn btn-link btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?');">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS -->
<script src="path/to/bootstrap.bundle.js"></script>
<?= $this->endSection(); ?>