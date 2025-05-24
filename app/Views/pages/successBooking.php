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
                <p class="text-danger"><strong>Note:</strong> Please make the payment within <strong>1 day</strong> to confirm your booking, or it will be automatically cancelled.</p>
            </div>

            <div class="card-footer text-center">
                <form method="post" action="<?= base_url('payment/createBill') ?>">
                    <input type="hidden" name="treatmentPrice" value="<?= $treatment['price'] * 100 ?>"> <!-- in cents -->
                    <input type="hidden" name="name" value="<?= session('patientName') ?>">
                    <input type="hidden" name="email" value="<?= session('patientEmail') ?>">
                    <input type="hidden" name="phone" value="<?= session('phone') ?>">

                    <button type="submit" class="btn btn-success w-100">Make Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>