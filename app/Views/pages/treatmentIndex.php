<?= $this->extend('layout/adminTemplate') ?>]

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Patient Treatment Records</h2>
    <a href="/treatment/create" class="btn btn-primary mb-3">Add New Record</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient ID</th>
                <th>Appointment ID</th>
                <th>Treatment ID</th>
                <th>Treatment Notes</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($treatments as $t): ?>
                <tr>
                    <td><?= esc($t['session_date']) ?></td>
                    <td><?= esc($t['patientId']) ?></td>
                    <td><?= esc($t['appointmentId']) ?></td>
                    <td><?= esc($t['treatmentId']) ?></td>
                    <td><?= esc($t['treatmentNotes']) ?></td>
                    <td><?= esc($t['status']) ?></td>
                    <td>
                        <a href="/treatment/edit/<?= $t['recordId'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/treatment/delete/<?= $t['recordId'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>