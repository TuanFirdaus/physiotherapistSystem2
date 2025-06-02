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
                <p class="card-text"><strong>Therapist Name:</strong> <?= $detailForm['therapistName']; ?></p>
                <p class="card-text"><strong>Patient Name:</strong> <?= esc($detailForm['patientName'] ?? $appointment['patientName']); ?></p>
                <p class="card-text"><strong>Email:</strong> <?= esc($detailForm['patientEmail'] ?? $appointment['patientEmail']); ?></p>
                <p class="card-text"><strong>Phone Number:</strong> <?= esc($detailForm['patientPhoneNum'] ?? $appointment['patientPhoneNum']); ?></p>
                <p class="card-text"><strong>Treatment Name:</strong> <?= esc($detailForm['treatmentName'] ?? $appointment['treatmentName']); ?></p>
                <p class="card-text"><strong>Treatment Price:</strong> RM <?= number_format($treatment['price'], 2); ?></p>
                <p class="card-text"><strong>Appointment Date:</strong> <?= esc($detailForm['date'] ?? $appointment['date']); ?></p>
                <p class="card-text"><strong>Time Slot:</strong> <?= esc($detailForm['startTime'] ?? $appointment['startTime']); ?> to <?= esc($detailForm['endTime'] ?? $appointment['endTime']); ?></p>
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
                <form action="/payment" method="post" class="d-inline">
                    <input type="hidden" name="treatmentPrice" value="<?= $treatment['price'] * 100 ?>"> <!-- in cents -->
                    <input type="hidden" name="patientName" value="<?= esc($detailForm['patientName'] ?? $appointment['patientName']); ?>">
                    <input type="hidden" name="patientEmail" value="<?= esc($detailForm['patientEmail'] ?? $appointment['patientEmail']); ?>">
                    <input type="hidden" name="phone" value="<?= esc($detailForm['patientPhoneNum'] ?? $appointment['patientPhoneNum']); ?>">
                    <input type="hidden" name="appointmentId" value="<?= esc($detailForm['appointmentId'] ?? $appointment['appointmentId']) ?>">
                    <input type="hidden" name="date" value="<?= esc($detailForm['date'] ?? '') ?>">
                    <input type="hidden" name="treatmentName" value="<?= esc($detailForm['treatmentName']) ?>">
                    <input type="hidden" name="treatmentPrice" value="<?= number_format($treatment['price'], 2); ?>">
                    <input type="hidden" name="patientPhoneNum" value="<?= esc($detailForm['patientPhoneNum'] ?? '') ?>">
                    <input type="hidden" name="status" value="<?= esc($detailForm['status'] ?? '') ?>">
                    <button type="submit" class="btn btn-success w-100">Make Payment</button>
                </form>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>