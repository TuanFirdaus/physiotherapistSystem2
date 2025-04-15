<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-5" style="min-height: 100vh;">
    <h2 class="text-center mb-4">Your Pending Appointments</h2>

    <?php if (!empty($appointments) && is_array($appointments)): ?>
        <div class="row justify-content-center">
            <?php foreach ($appointments as $appointment): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Appointment ID: <?= $appointment['appointmentId']; ?></h5> -->
                            <h5><strong>Appointment Details</strong></h5>
                            <p class="card-text"><strong>Therapist Name:</strong> <?= $appointment['name']; ?></p>
                            <p class="card-text"><strong>Email:</strong> <?= $appointment['email']; ?></p>
                            <p class="card-text"><strong>Slot: </strong>Date - <?= $appointment['date']; ?>, Time -<?= $appointment['startTime']; ?> to <?= $appointment['endTime']; ?></p>
                            <p class="card-text"><strong>Status:</strong>
                                <span class="badge bg-warning"><?= ucfirst($appointment['status']); ?></span>
                            </p>
                            <p class="text-danger mt-3"><strong>Note:</strong> Please make the deposit payment within <strong>1 day</strong> to confirm your booking, or it will be automatically cancelled.</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <form action="/cancelBooking" method="post" class="d-inline">
                                <input type="hidden" name="appointmentId" value="<?= $appointment['appointmentId']; ?>">
                                <button type="submit" class="btn btn-danger">Cancel Booking</button>
                            </form>
                            <a href="/payment/<?= $appointment['appointmentId']; ?>" class="btn btn-success">Pay Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            You have no pending appointments.
        </div>
    <?php endif; ?>

    <div class="container my-5">
        <h2 class=" mb-4">Appointment History</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Treatment Name</th>
                        <th>Price (RM)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($historyAppointments)) : ?>
                        <?php foreach ($historyAppointments as $index => $history) : ?>
                            <tr>
                                <td class="text-center"><?= $index + 1; ?></td>
                                <td><?= esc($history['treatmentName']); ?></td>
                                <td class="text-center"><?= number_format($history['treatmentPrice'], 2); ?></td>
                                <td class="text-center">
                                    <?php if ($history['status'] === 'cancelled') : ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php elseif ($history['status'] === 'approved') : ?>
                                        <span class="badge bg-primary">Approved</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary"><?= esc(ucfirst($history['status'])); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= esc(date('d M Y', strtotime($history['date']))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No appointment history found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>