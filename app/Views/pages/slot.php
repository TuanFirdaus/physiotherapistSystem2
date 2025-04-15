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
        <a href="/approveApp">Appointments</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/slotForm">Manage Slot</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<h1 class="text-center mb-5">Manage Slot</h1>

<!-- Therapist List -->
<div class="card ms-5 ">
    <div class="card-header">
        <div class="card-title">Therapist</div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Expertise</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($allTherapists as $therapist) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $therapist['name']; ?></td>
                        <td><?= $therapist['expertise']; ?></td>
                        <td><?= $therapist['availability']; ?></td>
                        <td>
                            <button class="btn btn-success">Detail</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container text-center text-white mb-5 mt-5 d-flex justify-content-center align-items-center" style="height: 40vh;">
    <!-- Slot Form -->
    <form action="/assignSlot" method="post" class="col-md-6 col-lg-4 mb-5 mt-5 p-3">
        <?= csrf_field() ?>
        <label class="mb-2 mt-5"><b>Assigned Slot</b></label>
        <!-- Date -->
        <div class="form-group form-group-default">
            <label>Date</label>
            <input id="Date" type="date" name="date" class="form-control" placeholder="Choose date" required>
        </div>
        <!-- Start Time -->
        <div class="form-group form-group-default mt-3">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <!-- End Time -->
        <div class="form-group form-group-default mt-3">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <!-- Therapist -->
        <div class="form-group form-group-default mt-3">
            <label>Select Therapist</label>
            <select class="form-select" id="formGroupDefaultSelect" name="therapistId" required>
                <?php foreach ($availableTherapists as $therapist): ?>
                    <option value="<?= $therapist['therapistId']; ?>">
                        <?= $therapist['name']; ?> <!-- Display name -->
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2 mb-4" id="alert_demo_3_2">Submit</button>

    </form>
</div>




<?= $this->endSection(); ?>