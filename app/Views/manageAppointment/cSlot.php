<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container d-flex justify-content-center align-items-center">
    <div class="col">
        <div class="row">
            <h2>You are choosing treatment <b><?= esc($treatmentName); ?></b></h2>
            <h2>Price: RM<?= esc($treatmentPrice); ?></h2>
            <h2>Therapist: <b><?= esc($therapistName); ?></b></h2>
            <h2>Therapist ID: <b><?= esc($therapistId); ?></b></h2>
            <h2>User ID: <b><?= esc(session()->get('userId')); ?></b></h2>
            <h2>treatmentId: <b><?= esc($treatmentId); ?></b></h2>
        </div>
    </div>
    <div class="col text-center" style="min-height: 100vh;">
        <!-- Display Slot Schedule -->
        <h3 style="color: #007BFF; text-align: center;">Get Your Slot!!</h3>
        <div style="overflow-x: auto; margin-top: 20px;">
            <form action="/confirmBooking" method="post">
                <!-- Add CSRF token if enabled -->
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
                                    <!-- Radio button for slot selection -->
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

                <!-- Hidden inputs to carry other required information -->
                <input type="hidden" name="userId" value="<?= esc(session()->get('userId')); ?>">
                <input type="hidden" name="treatmentId" value="<?= esc($treatmentId); ?>">
                <input type="hidden" name="treatmentName" value="<?= esc($treatmentName); ?>">
                <input type="hidden" name="treatmentPrice" value="<?= esc($treatmentPrice); ?>">
                <input type="hidden" name="therapistId" value="<?= esc($therapistId); ?>">
                <input type="hidden" name="therapistName" value="<?= esc($therapistName); ?>">

                <!-- Submit Button -->
                <div class="mt-4">
                    <button class="btn btn-success" type="submit">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>