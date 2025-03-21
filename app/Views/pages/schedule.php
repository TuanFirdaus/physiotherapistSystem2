<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="col text-center text-white mb-5 mt-5 justify-content-center align-items-center" style="min-height: 100vh;">
        <!-- Slot Form -->
        <form action="/schedule" method="post" class="col-md-6 col-lg-4 mb-5 mt-5">
            <?= csrf_field() ?>
            <label class="mb-3"><b>Slot Assigned</b></label>
            <div class="form-group form-group-default">
                <label>Date</label>
                <input id="Date" type="date" name="date" class="form-control" placeholder="Choose date" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

        <!-- Display Therapists -->
        <?php if (isset($therapistsSchedule) && !empty($therapistsSchedule)) : ?>
            <h3 style="color: #007BFF; text-align: center;">Your Schedule</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead style="background-color:rgb(253, 253, 253); text-align: left; color: #333;">
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #000;">Therapist</th>
                        <th style="padding: 10px; border-bottom: 2px solid #000;">Slot</th>
                        <th style="padding: 10px; border-bottom: 2px solid #000;">Time</th>
                        <th style="padding: 10px; border-bottom: 2px solid #000;">Status</th>
                    </tr>
                </thead>
                <tbody style="text-align: left;">
                    <?php foreach ($therapistsSchedule as $therapist) : ?>
                        <tr style="color: #333;">
                            <td style="padding: 10px; border-bottom: 1px solid #000;">
                                <strong><?= esc($therapist['name']) ?></strong><br>
                                <small style="color: #555;"><?= esc($therapist['email']) ?></small>
                            </td>
                            <td style="padding: 10px; border-bottom: 1px solid #000;">Slot<?= esc($therapist['slotId']) ?></td>
                            <td style="padding: 10px; border-bottom: 1px solid #000;"><?= esc($therapist['time']) ?></td>
                            <td style="padding: 10px; border-bottom: 1px solid #000;"><?= esc($therapist['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($therapistsSchedule)) : ?>
            <p style="text-align: center; color: #888;">No therapists assigned for the selected date.</p>
        <?php endif; ?>

    </div>
</div>


<?= $this->endSection(); ?>