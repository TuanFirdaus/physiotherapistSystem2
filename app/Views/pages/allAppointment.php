<?= $this->extend('layout/adminTemplate') ?>

<?= $this->section('breadcrumbs'); ?>
<ul class="page-breadcrumb">
    <li class="nav-home">
        <a href="/adminDashboard" class="nav-link">
            <i class="icon-home"></i>
        </a>
    </li>

    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/approveApp">All Appointment</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">All Appointments</h2>

    <form method="get" class="row mb-4">
        <div class="col-md-3">
            <label>Date:</label>
            <input type="date" name="date" class="form-control" value="<?= esc($filter_date) ?>">
        </div>
        <div class="col-md-3">
            <label>Therapist:</label>
            <select name="therapist_id" class="form-control">
                <option value="">All</option>
                <?php foreach ($therapists as $t): ?>
                    <option value="<?= $t['therapistId'] ?>" <?= $filter_therapist == $t['therapistId'] ? 'selected' : '' ?>>
                        <?= esc($t['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="Pending" <?= $filter_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Approved" <?= $filter_status == 'Approved' ? 'selected' : '' ?>>Approved</option>
                <option value="Completed" <?= $filter_status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                <option value="Cancelled" <?= $filter_status == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Select</th>
                <th>Date</th>
                <th>Time</th>
                <th>Therapist</th>
                <th>Patient</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td>
                            <input type="radio" name="appointment_ids[]" value="<?= esc($a['appointmentId']) ?>">
                            <input type="hidden" name="slotId" value="<?= esc($a['slotId']) ?>">
                            <input type="hidden" name="therapistId" value="<?= esc($a['therapistId']) ?>">
                            <input type="hidden" name="patientId" value="<?= esc($a['patientId']) ?>">
                        </td>
                        <td><?= esc($a['date']) ?></td>
                        <td><?= esc($a['startTime']) ?>-<?= esc($a['endTime']) ?></td>
                        <td><?= esc($a['therapist_name']) ?></td>
                        <td><?= esc($a['patient_name']) ?></td>
                        <td>
                            <?php
                            $status = esc($a['status']);
                            $statusColor = match ($status) {
                                'approved' => 'green',
                                'pending' => 'orange',
                                'cancelled' => 'red',
                                default => 'black'
                            };
                            ?>
                            <span style="color: <?= $statusColor ?>; font-weight: bold;">
                                <?= $status ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No appointments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <div class="mt-3 mb-3">

            <button type="submit" name="action" value="edit" class="btn btn-warning">Edit</button>

            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
        </div>

    </table>
</div>
<?= $this->endSection(); ?>