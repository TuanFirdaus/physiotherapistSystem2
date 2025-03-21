<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<!-- Therapist List -->
<div class="card ms-5 me-5">
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

<div class="container text-center text-white mb-5 mt-5 d-flex justify-content-center align-items-center" style="height: 40vh;">
    <!-- Slot Form -->
    <form action="/assignSlot" method="post" class="col-md-6 col-lg-4 mb-5 mt-5">
        <?= csrf_field() ?>
        <label class="mb-3"><b>Slot Assigned</b></label>
        <div class="form-group form-group-default">
            <label>Date</label>
            <input id="Date" type="date" name="date" class="form-control" placeholder="Choose date" required>
        </div>
        <div class="form-group form-group-default mt-3">
            <label>Time</label>
            <select class="form-select" id="time" name="time" required>
                <option value="09:00">09:00-10:00</option>
                <option value="11:00">11:00-12:00</option>
                <option value="14:00">14:00-15:00</option>
                <option value="16:00">16:00-17:00</option>
            </select>
        </div>
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

        <button type="submit" class="btn btn-primary mt-4" id="alert_demo_3_2">Submit</button>

    </form>
</div>



<?= $this->endSection(); ?>