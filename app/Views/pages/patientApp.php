<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5" style="min-height: 100vh;">
    <h2 class="text-center mb-4">My Patients Appointment Details</h2>
    <p>Therapist Name: <?= esc(session()->get('userName')); ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Phone Number</th>
                <th>Treatment Name</th>
                <th>Treatment Price</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= esc($appointment['patientName']) ?></td>
                        <td><?= esc($appointment['patientPhone']) ?></td>
                        <td><?= esc($appointment['treatmentName']) ?></td>
                        <td>RM<?= esc($appointment['treatmentPrice']) ?></td>
                        <td><?= esc($appointment['date']) ?></td>
                        <td><?= esc($appointment['time']) ?></td>
                        <td><?= esc($appointment['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>