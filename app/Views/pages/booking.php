<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
$session = session();
$userName = $session->get('name');
?>

<div class="container my-5">
    <!-- ai tk jdi lgi -->
    <h1>Welcome, <?= esc($userName); ?>!</h1>
    <h3 class="text-center mt-4">Not sure which treatment to choose?</h3>
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card p-3">
                <label>Part of Body in Pain:</label>
                <input type="text" id="bodyPart" class="form-control mb-2" placeholder="e.g. lower back, knee">

                <label>Description:</label>
                <textarea id="painDescription" class="form-control mb-2" rows="3" placeholder="Describe your symptoms..."></textarea>

                <button id="getSuggestion" class="btn btn-primary">Suggest Treatment</button>
            </div>
        </div>
    </div>
    <div id="aiSuggestionContainer" class="row justify-content-center mb-5" style="display:none;"></div>
    <input type="hidden" name="treatmentPrice" value="${data.treatmentPrice}">
    <input type="hidden" name="treatmentId" value="${data.treatmentId}">


    <?php if (isset($error)): ?>
        <div style="color: red; font-weight: bold;">
            ⚠️ Error: <?= esc($error) ?>
        </div>
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
<script>
    document.getElementById('getSuggestion').addEventListener('click', function() {
        const bodyPart = document.getElementById('bodyPart').value.trim();
        const description = document.getElementById('painDescription').value.trim();

        if (!bodyPart || !description) {
            alert("Please fill in both fields.");
            return;
        }

        fetch('/getSuggestion', {
                method: 'POST',
                body: JSON.stringify({
                    bodyPart,
                    description
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.treatment && data.treatmentPrice && data.treatmentId) {
                    const suggestionHtml = `
            <div class="col-md-4">
                <form action="/patientTreatment" method="post">
                    <div class="card-pricing2 card-warning h-100">
                        <div class="pricing-header">
                            <h3 class="fw-bold mb-3">${data.treatment}</h3>
                            <span class="sub-title">AI Suggested</span>
                        </div>
                        <div class="price-value">
                            <div class="value">
                                <span class="currency">RM</span>
                                <span class="amount">${parseFloat(data.treatmentPrice).toFixed(2)}</span>
                                <span class="month">/session</span>
                            </div>
                        </div>
                        <ul class="pricing-content">
                            <li>Suggested based on your symptoms</li>
                        </ul>
                        <input type="hidden" name="treatmentName" value="${data.treatment}">
                        <input type="hidden" name="treatmentPrice" value="${data.treatmentPrice}">
                        <input type="hidden" name="treatmentId" value="${data.treatmentId}">
                        <button class="btn btn-warning btn-border btn-lg w-75 fw-bold mb-3" type="submit">Choose</button>
                    </div>
                </form>
            </div>
        `;
                    document.getElementById('aiSuggestionContainer').innerHTML = suggestionHtml;
                    document.getElementById('aiSuggestionContainer').style.display = 'flex';
                } else {
                    alert("AI could not suggest a treatment.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error contacting AI service.");
            });
    });
</script>

<?= $this->endSection(); ?>