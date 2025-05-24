<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h2 class="mb-1 text-success"><i class="fa fa-credit-card"></i> Payment</h2>
            <p class="text-muted">Please confirm your details before proceeding.</p>
        </div>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <form method="post" action="<?= base_url('payment/createBill') ?>">
            <input type="hidden" name="appointmentId" value="<?= old('appointmentId', esc($appointmentId)) ?>">
            <input type="hidden" name="treatmentPrice" value="<?= old('treatmentPrice', esc($treatmentPrice)) ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" value="<?= old('name', esc($name)) ?>" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" value="<?= old('email', esc($email)) ?>" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="phone" value="<?= old('phone', esc($phone)) ?>" class="form-control" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Amount to Pay</label>
                <div class="input-group">
                    <span class="input-group-text">RM</span>
                    <input type="text" class="form-control bg-light" value="<?= old('treatmentPrice', esc(number_format($treatmentPrice, 2))) ?>" readonly>
                </div>
            </div>
            <input type="hidden" name="treatmentName" value="<?= esc($treatmentName) ?>">
            <input type="hidden" name="patientName" value="<?= esc($name) ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">AppointmentID</label>
                <input type="text" name="appointmentId" value="<?= old('appointmentId', esc($appointmentId)) ?>" class="form-control" readonly>
            </div>


            <button type="submit" class="btn btn-success w-100">
                <i class="fa fa-check-circle"></i> Pay Now
            </button>
        </form>
    </div>
</div>

<!-- Optionally include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?= $this->endSection(); ?>