<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>

<h2 class="text-center mb-4">Admin Dashboard</h2>

<!-- Overview Cards -->
<div class="row">
    <div class="col-sm-6 col-md-3" style="width: 40vh;">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total User</p>
                            <p class="card-title">
                                <?php foreach ($totalUser as $user): ?>
                                    <li class="card-text"><?= ucfirst($user['role']) ?> - <?= $user['total']  ?></li>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3" style="width: 40vh;">
        <div class=" card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="icon-book-open"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Appointments (Completed)</p>
                            <p class="card-title" style="font-size: medium; height: 40px"><?= $totalAppointment ?> appointments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3" style="width: 40vh;">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-danger bubble-shadow-small">
                            <i class="icon-wallet"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Pending Payments</p>
                            <p class="card-text" style="font-size: medium; height: 40px"><?= $totalPendingPayments ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3" style="width: 40vh; ">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-warning bubble-shadow-small">
                            <i class="icon-pencil"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Treatment Records</p>
                            <p class="card-text" style="font-size: medium; height: 40px"><?= $totalTreatmentRecords ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add charts or graphs here to visualize data -->
<div class="row justify-content-center align-items-center">
    <!-- Appointments Statistics Chart -->
    <div class="col-md-6" style="width: auto;">
        <div class="card card-round mb-4">
            <div class="card-header">
                <div class="card-head-row flex-column align-items-start">
                    <div class="card-title mb-1">Appointments Statistics</div>


                    <!-- <div class="card-tools">
                        <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                            <span class="btn-label">
                                <i class="fa fa-pencil"></i>
                            </span>
                            Export
                        </a>
                        <a href="#" class="btn btn-label-info btn-round btn-sm">
                            <span class="btn-label">
                                <i class="fa fa-print"></i>
                            </span>
                            Print
                        </a>
                    </div> -->
                </div>
                <span class="badge bg-primary">Completed</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <div class="graphBox d-flex justify-content-center">
                        <div class="box" style="width: auto;">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Table -->
    <div class="col-md-6" style="width: auto;">
        <div class="card card-round mb-4">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Recent Appointments</div>
                    <div class="card-tools">
                        <div class="dropdown">
                            <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Appointment Number</th>
                                <th scope="col" class="text-end">Date &amp; Time</th>
                                <th scope="col" class="text-end">Treament</th>
                                <th scope="col" class="text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentAppointments)): ?>
                                <?php foreach ($recentAppointments as $appointment): ?>
                                    <tr>
                                        <th scope="row">
                                            Appointment #<?= esc($appointment['appointmentId']) ?>
                                        </th>
                                        <td class="text-end">
                                            <?= date('M d, Y', strtotime($appointment['date'])) ?>
                                            <br>
                                            <small><?= date('g:ia', strtotime($appointment['startTime'])) ?> - <?= date('g:ia', strtotime($appointment['endTime'])) ?></small>
                                        </td>
                                        <td class="text-end"><?= esc($appointment['treatmentName']) ?></td>
                                        <td class="text-end">
                                            <?php if ($appointment['status'] == 'Approved'): ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif ($appointment['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php elseif ($appointment['status'] == 'cancelled'): ?>
                                                <span class="badge bg-danger">Cancelled</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary"><?= esc(ucfirst($appointment['status'])) ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No recent appointments found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const chartData = <?= $chartData ?>;
</script>






<?= $this->endSection(); ?>