<?= $this->extend('layout/therapistTemp') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3 class="mb-4">My Patients & Appointments</h3>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Treatment Outcome</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $i => $app): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($app['patient_name']) ?></td>
                                <td><?= esc($app['email']) ?></td>
                                <td><?= esc($app['phoneNo']) ?></td>
                                <td><?= esc($app['appointment_date'] ?? '-') ?></td>
                                <td><?= esc($app['status']) ?></td>
                                <td>
                                    <?php
                                    // Fetch treatment outcome if exists
                                    $db = \Config\Database::connect();
                                    $record = $db->table('patienttreatmentrecord')->where('appointmentId', $app['appointmentId'])->get()->getRowArray();
                                    echo $record ? esc($record['outcome']) : '<span class="text-muted">Not added</span>';
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('therapist/addTreatmentOutcome/' . $app['appointmentId']) ?>" class="btn btn-primary btn-sm">
                                        <?= $record ? 'Edit Outcome' : 'Add Outcome' ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>