<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
// Retrieve session data
$session = session(); // Access the session instance
$userName = $session->get('name'); // Get the 'userName' session variable
?>
<div class="container my-5">
    <h1>Welcome, <?= esc(session()->get('userName')); ?>!</h1> <!-- Display user name -->
    <h1>Booking appointment in 3 step only!</h1>
    <p class="text-muted">Follow the steps below to book an appointment.</p>
    <div class="row align-items-center justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Step 1</h5>
                    <p class="card-text"><strong>Choose your package treatment</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Step 2</h5>
                    <p class="card-text"><strong>Choose your therapist </strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Step 3</h5>
                    <p class="card-text"><strong> Get your slot</strong></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Pricing Cards -->
    <h2 class="fw-bold text-center mb-3 mt-5">Pricing</h2>
    <div class="container my-5">
        <div class="row d-flex text-center align-items-center justify-content-center">
            <?php foreach ($getTreatment as $treatment) : ?>
                <div class="col-md-4 mb-4"> <!-- Each card takes 1/3 of the row -->
                    <div class="card h-100"> <!-- h-100 ensures equal height for all cards -->
                        <form action="/patientTreatment" method="post"> <!-- Form inside the card -->
                            <div class="card-body">
                                <h5 class="card-title"><?= $treatment['name']; ?></h5>
                                <!-- Hidden inputs to send the correct treatment data -->
                                <input type="hidden" name="treatmentName" value="<?= $treatment['name']; ?>">
                                <h6 class="card-price">RM<?= $treatment['price']; ?></h6>
                                <input type="hidden" name="treatmentPrice" value="<?= $treatment['price']; ?>">
                                <input type="hidden" name="treatmentId" value="<?= $treatment['treatmentId']; ?>">
                                <?php
                                // Split the details string by "-"
                                $details = explode('-', $treatment['details']);
                                ?>
                                <ul class="list-unstyled">
                                    <?php foreach ($details as $detail) : ?>
                                        <li><?= trim($detail); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <!-- Button submits the form -->
                                <button class="btn btn-dark mt-3" type="submit">Choose</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>




</div>


<?= $this->endSection(); ?>