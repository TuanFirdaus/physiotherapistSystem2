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
        <a href="/ManageSlot">Manage Slots</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="#">Edit Slot</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h4 class="mb-4">Edit Slot</h4>
    <form method="post" action="/slots/update" class="card p-4 shadow-sm">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="slotId" class="form-label">Slot ID</label>
            <input type="text" class="form-control" id="slotId" name="slotId" value="<?= $slot['slotId'] ?>" readonly>
        </div>


        <div class="mb-3">
            <label for="therapistName" class="form-label">Therapist Name</label>
            <select class="form-select" name="therapistId" required>
                <?php foreach ($availableTherapists as $therapist): ?>
                    <option value="<?= $therapist['therapistId']; ?>">
                        <?= $therapist['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?= $slot['date'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="startTime" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="startTime" name="startTime" value="<?= $slot['startTime'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="endTime" class="form-label">End Time</label>
            <input type="time" class="form-control" id="endTime" name="endTime" value="<?= $slot['endTime'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="pending" <?= $slot['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="booked" <?= $slot['status'] === 'booked' ? 'selected' : '' ?>>Booked</option>
                <option value="cancelled" <?= $slot['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="/slot/manage" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Slot</button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>