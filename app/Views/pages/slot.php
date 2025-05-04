<?= $this->extend('layout/adminTemplate') ?>

<?= $this->section('breadcrumbs'); ?>
<ul class="page-breadcrumb mt-2">
    <li class="nav-home">
        <a href="/adminDashboard" class="nav-link">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="/approveApp">Appointments</a></li>
    <li class="separator"><i class="icon-arrow-right"></i></li>
    <li class="nav-item"><a href="/slotForm">Manage Slot</a></li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="container-fluid mt-4">
    <div class="row">

        <!-- Therapist List Card -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Therapist List</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Expertise</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($allTherapists as $therapist): ?>
                                <tr>
                                    <th><?= $i++; ?></th>
                                    <td><?= $therapist['name']; ?></td>
                                    <td><?= $therapist['expertise']; ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = match ($therapist['availability']) {
                                            'available' => 'bg-primary',
                                            'unavailable' => 'bg-danger',
                                            default => 'bg-warning'
                                        };
                                        $statusText = ucfirst($therapist['availability']);
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Assign Slot Form -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Assign Slot</h4>
                </div>
                <div class="card-body">
                    <form action="/assignSlot" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Therapist</label>
                            <select class="form-select" name="therapistId" required>
                                <?php foreach ($availableTherapists as $therapist): ?>
                                    <option value="<?= $therapist['therapistId']; ?>">
                                        <?= $therapist['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-black w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Flash Messages -->
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>