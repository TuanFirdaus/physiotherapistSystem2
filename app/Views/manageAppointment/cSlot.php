<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container d-flex justify-content-center ">
    <div class="row justify-content-center mb-4">
        <div class="col">
            <div class="card shadow-lg border-primary" style="width: 40vh;">
                <div class="card-body">
                    <h3 class="card-title text-primary mb-3">
                        <i class="fas fa-notes-medical"></i> Treatment Selection
                    </h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-stethoscope text-success"></i>
                            <strong>Treatment:</strong> <?= esc($treatmentName); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-money-bill-wave text-warning"></i>
                            <strong>Price:</strong> RM<?= esc($treatmentPrice); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-user-md text-info"></i>
                            <strong>Therapist:</strong> <?= esc($therapistName); ?> (ID: <?= esc($therapistId); ?>)
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-user text-secondary"></i>
                            <strong>Your User ID:</strong> <?= esc(session()->get('userId')); ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-id-badge text-primary"></i>
                            <strong>Treatment ID:</strong> <?= esc($treatmentId); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col text-center ms-3" style="min-height: 100vh;">
        <div class="card mb-3 shadow-sm border-info" style="background: #f8f9fa;">
            <div class="card-body">
                <h3 class="card-title text-info mb-1">
                    <i class="fas fa-calendar-check"></i> Choose Your Preferred Time Slot
                </h3>
                <p class="card-text text-muted" style="font-size: 1.1rem;">
                    Select a slot that fits your schedule and confirm your booking below.
                </p>
            </div>
        </div>
        <div style="overflow-x: auto; margin-top: 20px;">
            <?php if (empty($slotSchedule)): ?>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-calendar-times" style="font-size: 2rem; color: #dc3545;"></i><br>
                    <strong>No slot available.</strong>
                </div>
                <form action="<?= base_url('/patientTreatment') ?>" method="post" class="d-inline">
                    <input type="hidden" name="treatmentId" value="<?= esc($treatmentId) ?>">
                    <input type="hidden" name="treatmentName" value="<?= esc($treatmentName) ?>">
                    <input type="hidden" name="treatmentPrice" value="<?= esc($treatmentPrice) ?>">
                    <input type="hidden" name="therapistId" value="<?= esc($therapistId) ?>">
                    <button type="submit" class="btn btn-outline-secondary mt-3">
                        <i class="fa fa-arrow-left"></i> Back to Previous
                    </button>
                </form>
            <?php else: ?>
                <form action="<?= site_url('/confirmBooking') ?>" method="post">
                    <?= csrf_field() ?>
                    <table style="width: 85%; border-collapse: collapse; margin: auto;">
                        <thead style="background-color:rgb(13, 66, 145); text-align: center; color: #fff;">
                            <tr>
                                <th style="padding: 10px; border: 1px solid #000;">Slot</th>
                                <th style="padding: 10px; border: 1px solid #000;">Start Time</th>
                                <th style="padding: 10px; border: 1px solid #000;">End Time</th>
                                <th style="padding: 10px; border: 1px solid #000;">Date</th>
                                <th style="padding: 10px; border: 1px solid #000;">Status</th>
                                <th style="padding: 10px; border: 1px solid #000; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <?php foreach ($slotSchedule as $schedule) : ?>
                                <tr style="color: #333;">
                                    <td style="padding: 10px; border: 1px solid #000;">Slot<?= esc($schedule['slotId']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #000;"><?= esc($schedule['startTime']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #000;"><?= esc($schedule['endTime']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #000;"><?= esc($schedule['date']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #000;"><?= esc($schedule['status']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #000; text-align: center;">
                                        <input
                                            type="radio"
                                            name="slotId"
                                            value="<?= esc($schedule['slotId']); ?>"
                                            id="slot<?= esc($schedule['slotId']); ?>"
                                            required>
                                        <label for="slot<?= esc($schedule['slotId']); ?>">Select</label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="userId" value="<?= esc(session()->get('userId')); ?>">
                    <input type="hidden" name="treatmentId" value="<?= esc($treatmentId); ?>">
                    <input type="hidden" name="treatmentName" value="<?= esc($treatmentName); ?>">
                    <input type="hidden" name="treatmentPrice" value="<?= esc($treatmentPrice); ?>">
                    <input type="hidden" name="therapistId" value="<?= esc($therapistId); ?>">
                    <input type="hidden" name="therapistName" value="<?= esc($therapistName); ?>">
                    <div class="mt-4">
                        <button class="btn btn-success" type="submit">Confirm Booking</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add FontAwesome for the icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?= $this->endSection(); ?>