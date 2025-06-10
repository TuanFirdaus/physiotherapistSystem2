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
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <script>
        // Auto-dismiss alerts after 3 seconds
        setTimeout(function() {
            var alertNode = document.querySelector('.alert');
            if (alertNode) {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                bsAlert.close();
            }
        }, 3000);
    </script>

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
                <th>Date</th>
                <th>Time</th>
                <th>Therapist</th>
                <th>Patient</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td><?= esc($a['date']) ?></td>
                        <td><?= esc($a['startTime']) ?>-<?= esc($a['endTime']) ?></td>
                        <td><?= esc($a['therapist_name']) ?></td>
                        <td><?= esc($a['patient_name']) ?></td>
                        <td>
                            <?php
                            $status = esc($a['status']);
                            $statusColor = match ($status) {
                                'Approved' => 'green',
                                'Pending' => 'orange',
                                'cancelled' => 'red',
                                default => 'black'
                            };
                            ?>
                            <span style="color: <?= $statusColor ?>; font-weight: bold;">
                                <?= $status ?>
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton<?= esc($a['appointmentId']) ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= esc($a['appointmentId']) ?>">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('appointments/edit/' . esc($a['appointmentId'])) ?>">Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('appointments/delete/' . esc($a['appointmentId'])) ?>"
                                            onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
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