<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 28rem;">
            <div class="card-header text-center bg-primary text-white">
                <h3>Your Appointment</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Booking Details</h5>
                <p class="card-text"><strong>Appointment ID:</strong> <?= $appointment['appointmentId']; ?></p>
                <p class="card-text"><strong>Therapist ID:</strong> <?= $appointment['therapistId']; ?></p>
                <p class="card-text"><strong>Status:</strong>
                    <span class="badge 
                        <?= $appointment['status'] === 'pending' ? 'bg-warning' : ($appointment['status'] === 'confirmed' ? 'bg-success' : 'bg-danger'); ?>">
                        <?= ucfirst($appointment['status']); ?>
                    </span>
                </p>
                <hr>
            </div>
            <div class="card-footer text-center">
                <a href="/" class="btn btn-success w-100">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>