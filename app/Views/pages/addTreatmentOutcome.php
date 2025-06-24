<?= $this->extend('layout/therapistTemp') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <h3>Add/Edit Treatment Outcome</h3>
    <form action="<?= base_url('therapist/saveTreatmentOutcome') ?>" method="post">
        <div class="mb-3">
            <label for="treatment_outcome" class="form-label">Treatment Outcome</label>
            <textarea class="form-control" id="treatment_outcome" name="treatment_outcome" rows="4" required><?= esc($outcome ?? '') ?></textarea>
        </div>
        <input type="text" name="treatmentId" value="<?= esc($treatmentId ?? '') ?>" readonly>

        <div class="mb-3">
            <label for="pain_rate" class="form-label">Pain Rate After Session (0-10)</label>
            <input type="number" class="form-control" id="pain_rate" name="pain_rate" min="0" max="10" required value="<?= esc($pain_rate ?? '') ?>">
        </div>

        <input type="text" name="appointmentId" value="<?= esc($appointmentId ?? '') ?>">
        <button type="submit" class="btn btn-success">Save Outcome</button>
        <a href="<?= base_url('therapist/myPatients') ?>" class="btn btn-secondary">Back</a>
    </form>
</div>

<?= $this->endSection() ?>