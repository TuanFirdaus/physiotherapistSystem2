<?= $this->extend('layout/adminTemplate'); ?>

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
        <a href="/approveApp">Pending Appointment</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-2">
    <!-- Flash Messages -->
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
</div>

<div class="container">
    <h2 class="text-center mb-4">Pending Appointments</h2>

    <!-- Pending Appointments Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Treatment Name</th>
                <th>Phone Number</th>
                <th>Treatment Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="appointmentTable">
            <?php if (!empty($pendingAppointments)): ?>
                <?php foreach ($pendingAppointments as $pendingAppointment): ?>
                    <?php if ($pendingAppointment['status'] === 'pending'): ?>
                        <tr>
                            <td><?= esc($pendingAppointment['appointmentId']) ?></td>
                            <td><?= esc($pendingAppointment['patientName']) ?></td>
                            <td><?= esc($pendingAppointment['treatmentName']) ?></td>
                            <td><?= esc($pendingAppointment['patientPhoneNum']) ?></td>
                            <td><?= esc($pendingAppointment['treatmentPrice']) ?></td>
                            <td>
                                <span class="badge bg-warning"><?= ucfirst(esc($pendingAppointment['status'])) ?></span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    <form action="/appointments/approve/<?= esc($pendingAppointment['appointmentId']) ?>" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="<?= esc($pendingAppointment['status']) ?>">
                                        <button type="submit" data-bs-toggle="tooltip" title="Approve Appointment" class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="/appointments/delete/<?= esc($pendingAppointment['appointmentId']) ?>" method="post" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" data-bs-toggle="tooltip" title="Reject Appointment" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this appointment?');">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="no-appointments">
                            <i class="bi bi-emoji-frown" alt="No Appointments" style="width: 250px; margin-bottom: 10px;"></i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                            </svg>
                            <p class="text-muted">No pending appointments found.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?= $this->endSection(); ?>