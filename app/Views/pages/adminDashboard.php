<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>

<h2 class="text-center mb-4">Admin Dashboard</h2>

<!-- Overview Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body" style="height: auto;">
                <h5 class="card-title">Total Users</h5>

                <?php foreach ($totalUser as $user): ?>
                    <li><?= ucfirst($user['role']) ?> - <?= $user['total']  ?> user</li>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Appointments</h5>
                <p class="card-text" style="font-size: medium; height: 40px"><?= $totalAppointment ?> appointments</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pending Payments</h5>
                <p class="card-text" style="font-size: medium; height: 40px"><?= $totalPendingPayments ?> pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Treatment Records</h5>
                <p class="card-text" style="height: 40px"><?= $totalTreatmentRecords ?> records</p>
            </div>
        </div>
    </div>
</div>

<!-- Add charts or graphs here to visualize data -->
<div class="row">
    <div class="col-md-6">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Appointments Statistics</div>
                    <div class="card-tools">
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
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <!--
                       Added d-flex and justify-content-center here.
                       d-flex: Makes this div a flex container.
                       justify-content-center: Centers its direct children (the .box div) horizontally along the main axis.
                       Removed text-center as flex handles the block centering now.
                       Removed justify-content-center and align-items-center from the inner .box div
                       as they are not needed there for centering the box itself.
                    -->
                    <div class="graphBox d-flex justify-content-center">
                        <div class="box"> <!-- This inner div might not even be necessary depending on Chart.js behavior -->
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- recent bookings -->
<div class="row">
    <div class="col-md-8">
        <div class="card card-round">
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
                    <!-- Projects table -->
                    <table class="table align-items-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Payment Number</th>
                                <th scope="col" class="text-end">Date &amp; Time</th>
                                <th scope="col" class="text-end">Amount</th>
                                <th scope="col" class="text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                    <span class="badge badge-success">Completed</span>
                                </td>
                            </tr>
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