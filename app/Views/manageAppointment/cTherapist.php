<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container" style="min-height: 100vh">
    <div class="col">
        <div class="row">
            <h1>You are choosing treatment <b><?= esc($treatmentName); ?></b></h1>
            <h2>Price: RM<?= esc($treatmentPrice); ?></h2>
            <h2>treatmentId: <b><?= esc($treatmentId); ?></b></h2>
        </div>
    </div>

    <div class="container my-5">
        <div class="row align-items-center justify-content-center">
            <?php foreach ($getTherapist as $therapist) : ?>
                <div class="col-md-4 mb-4 animate-card"> <!-- Add a class for animation -->
                    <div class="card h-100 shadow therapist-card">
                        <form action="/confirmTherapist" method="post">
                            <img src="<?= base_url(!empty($therapist['profile_image']) ? esc($therapist['profile_image']) : 'assets/img/defaultProfilePic.jpg'); ?>"
                                class="card-img-top"
                                alt="<?= esc($therapist['name']); ?>"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= esc($therapist['name']); ?></h5>
                                <p class="card-text">Expertise: <?= esc($therapist['expertise']); ?></p>
                                <input type="hidden" name="therapistId" value="<?= esc($therapist['therapistId']); ?>">
                                <input type="hidden" name="therapistName" value="<?= esc($therapist['name']); ?>">
                                <input type="hidden" name="treatmentId" value="<?= esc($treatmentId); ?>">
                                <input type="hidden" name="treatmentName" value="<?= esc($treatmentName); ?>">
                                <input type="hidden" name="treatmentPrice" value="<?= esc($treatmentPrice); ?>">
                                <button class="btn btn-primary mt-2" type="submit">Select <?= esc($therapist['name']); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($getTherapist)) : ?>
                <div class="col text-center">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #dc3545;"></i><br>
                        <strong>No therapists available at the moment.</strong>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <form action="<?= base_url('/booking') ?>" method="post" class="d-inline">
            <input type="hidden" name="treatmentId" value="<?= esc($treatmentId) ?>">
            <input type="hidden" name="treatmentName" value="<?= esc($treatmentName) ?>">
            <input type="hidden" name="treatmentPrice" value="<?= esc($treatmentPrice) ?>">

            <button type="submit" class="btn btn-outline-secondary mt-3">
                <i class="fa fa-arrow-left"></i> Back to Previous
            </button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.therapist-card');

        // Add a bounce animation on card click
        cards.forEach(card => {
            card.addEventListener('click', function() {
                card.style.transition = 'transform 0.2s ease';
                card.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 200);
            });
        });
    });
</script>


<?= $this->endSection(); ?>