<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
$session = session();
$userName = $session->get('name');
?>

<div class="container my-5">
    <h1>Welcome, <?= esc($userName); ?>!</h1>
    <h1>Booking appointment in 3 steps only!</h1>
    <p class="text-muted">Follow the steps below to book an appointment.</p>

    <h2>🧍 Identify Your Pain Area</h2>
    <img src="/assets2/assets/img/anatomy.png" alt="Human Body Diagram" style="max-width: 600px;"><br><br>

    <form method="post" action="<?= base_url('pain-report') ?>">
        <label for="body_part">🦴 Pain Location (e.g., Neck, Lower back):</label><br>
        <input type="text" name="body_part" id="body_part" required value="<?= esc($body_part ?? '') ?>"><br><br>

        <label for="pain_description">💬 Describe the Pain:</label><br>
        <textarea name="pain_description" id="pain_description" rows="4" required><?= esc($pain_description ?? '') ?></textarea><br><br>

        <button type="submit">Get Treatment Suggestion</button>
    </form>

    <?php if (isset($recommendation)): ?>
        <hr>
        <h3>🧠 AI Suggested Treatment</h3>
        <p><?= nl2br(esc($recommendation)) ?></p>

        <h3>📋 Book Treatment</h3>
        <form method="post" action="<?= base_url('pain-report/book') ?>">
            <input type="hidden" name="part" value="<?= esc($body_part) ?>">
            <input type="hidden" name="description" value="<?= esc($pain_description) ?>">
            <input type="hidden" name="treatment" value="<?= esc($recommendation) ?>">

            <label>Your Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Contact Info:</label><br>
            <input type="text" name="contact" required><br><br>

            <button type="submit">Book This Treatment</button>
        </form>
    <?php endif; ?>

    <!-- Pricing Cards First -->
    <h2 class="fw-bold text-center mb-3 mt-5">Available Treatment Packages</h2>
    <div class="row justify-content-center align-items-center mb-5">
        <?php foreach ($getTreatment as $index => $treatment) : ?>
            <?php
            $cardColors = ['card-success', 'card-primary', 'card-secondary'];
            $cardClass = $cardColors[$index % count($cardColors)];
            $treatmentName = $treatment['name'] ?? 'Unnamed Treatment';
            $details = isset($treatment['details']) ? explode('-', $treatment['details']) : ['No details provided'];
            $price = $treatment['price'] ?? 0.00;
            $priceMain = floor($price);
            $priceCents = str_pad(($price * 100) % 100, 2, '0', STR_PAD_LEFT);
            ?>
            <div class="col-md-3 ps-md-0 mb-4">
                <form action="/patientTreatment" method="post">
                    <div class="card-pricing2 <?= $cardClass ?> h-100">
                        <div class="pricing-header">
                            <h3 class="fw-bold mb-3"><?= htmlspecialchars($treatmentName); ?></h3>
                            <span class="sub-title">Treatment Package</span>
                        </div>
                        <div class="price-value">
                            <div class="value">
                                <span class="currency">RM</span>
                                <span class="amount"><?= $priceMain ?>.<span><?= $priceCents ?></span></span>
                                <span class="month">/session</span>
                            </div>
                        </div>
                        <ul class="pricing-content">
                            <?php foreach ($details as $detail) : ?>
                                <li><?= trim($detail); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="treatmentName" value="<?= htmlspecialchars($treatmentName); ?>">
                        <input type="hidden" name="treatmentPrice" value="<?= htmlspecialchars($price); ?>">
                        <input type="hidden" name="treatmentId" value="<?= htmlspecialchars($treatment['treatmentId'] ?? ''); ?>">
                        <button class="btn <?= str_replace('card-', 'btn-', $cardClass) ?> btn-border btn-lg w-75 fw-bold mb-3" type="submit">Choose</button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>


</div>

<?= $this->endSection(); ?>