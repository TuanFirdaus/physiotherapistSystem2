<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
$session = session();
$userName = $session->get('userName') ?? 'Guest';
?>

<div class="container my-5">
    <!-- Welcome Message -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Welcome, <?= esc($userName); ?>!</h1>
        <p class="lead text-muted">Let us help you find the right treatment for your pain</p>
    </div>

    <!-- AI Suggestion Alert -->
    <div id="aiAlert" class="row justify-content-center" style="display:none;">
        <div class="col-md-6">
            <div class="alert alert-warning alert-dismissible fade show shadow-lg text-center" role="alert">
                <span id="aiAlertMessage">AI could not suggest a treatment.</span>
                <button type="button" class="btn-close" onclick="document.getElementById('aiAlert').style.display='none'"></button>
            </div>
        </div>
    </div>

    <!-- AI Suggestion Form -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-header bg-gradient-primary text-white text-center rounded-top">
                    <h4 class="mb-0 fw-bold">Not sure which treatment to choose?</h4>
                    <small class="fs-6">Describe your symptoms and get a recommendation</small>
                </div>
                <div class="card-body bg-light shadow-sm">
                    <div class="form-group mb-4">
                        <label for="bodyPart" class="form-label fw-semibold">Body Part in Pain</label>
                        <input type="text" id="bodyPart" class="form-control shadow-sm border-light" placeholder="e.g. lower back, knee, shoulder">
                    </div>
                    <div class="form-group mb-4">
                        <label for="painDescription" class="form-label fw-semibold">Description</label>
                        <textarea id="painDescription" class="form-control shadow-sm border-light" rows="4" placeholder="Describe the type, severity, and frequency of pain..."></textarea>
                    </div>
                    <div class="d-grid">
                        <button id="getSuggestion" class="btn btn-primary btn-lg fw-bold shadow-lg hover-shadow-lg transition-all">
                            <span id="loadingText">Suggest Treatment</span>
                            <span id="spinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Suggestion Result Modal (Overlay Popup) -->
    <div id="aiSuggestionModal" class="modal fade" tabindex="-1" aria-labelledby="aiSuggestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="aiSuggestionModalLabel">AI Suggested Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Treatment Name -->
                    <h4 id="suggestedTreatmentName" class="fw-bold mb-3"></h4>

                    <!-- Treatment Price -->
                    <p id="suggestedTreatmentPrice" class="card-text text-muted mb-2"></p>

                    <!-- Treatment Reason -->
                    <ul id="suggestedTreatmentDetails" class="list-group list-group-flush mb-3"></ul>

                    <!-- Form to choose the suggested treatment -->
                    <form id="suggestionForm" action="/patientTreatment" method="post">
                        <input type="hidden" name="treatmentName" id="treatmentName">
                        <input type="hidden" name="treatmentPrice" id="treatmentPrice">
                        <input type="hidden" name="treatmentId" id="treatmentId">
                        <button class="btn btn-success fw-semibold w-75" type="submit">Choose Treatment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Hidden Inputs for Passing Treatment Info -->
    <input type="hidden" name="treatmentPrice" value="${data.treatmentPrice}">
    <input type="hidden" name="treatmentId" value="${data.treatmentId}">

    <!-- Error Message -->
    <?php if (isset($error)): ?>
        <div class="text-center text-danger fw-bold">
            ⚠️ Error: <?= esc($error) ?>
        </div>
    <?php endif; ?>


    <div class="mt-5">
        <!-- Pricing Cards First -->
        <h2 class=" fw-bold text-center mb-3 mt-5">Available Treatment Packages</h2>
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

</div>
<script>
    document.getElementById('getSuggestion').addEventListener('click', function() {
        const bodyPart = document.getElementById('bodyPart').value.trim();
        const description = document.getElementById('painDescription').value.trim();
        const button = document.getElementById('getSuggestion');
        const spinner = document.getElementById('spinner');
        const text = document.getElementById('loadingText');

        // Validation
        if (!bodyPart || !description) {
            alert("Please fill in both fields.");
            return;
        }

        // Show loading state
        button.disabled = true;
        spinner.classList.remove('d-none');
        text.innerText = 'Loading...';

        // Send request
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
                if (data.treatmentName && data.treatmentPrice && data.treatmentId) {
                    // Update modal content
                    document.getElementById('suggestedTreatmentName').textContent = data.treatmentName;
                    document.getElementById('suggestedTreatmentPrice').innerHTML = `Estimated Price: <strong>RM ${parseFloat(data.treatmentPrice).toFixed(2)}</strong>`;
                    document.getElementById('suggestedTreatmentDetails').innerHTML = `
                    <li class="list-group-item">Reason: ${data.treatmentReason || 'Based on your symptoms'}</li>
                `;
                    document.getElementById('treatmentName').value = data.treatmentName;
                    document.getElementById('treatmentPrice').value = data.treatmentPrice;
                    document.getElementById('treatmentId').value = data.treatmentId;

                    // Show modal with fade-in effect
                    const modal = new bootstrap.Modal(document.getElementById('aiSuggestionModal'));
                    modal.show();
                } else {
                    alert("AI could not suggest a treatment. Try again with more details.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Something went wrong while contacting the AI.");
            })
            .finally(() => {
                // Always remove loading state after response
                spinner.classList.add('d-none');
                text.innerText = 'Suggest Treatment';
                button.disabled = false;
            });
    });
</script>


<?= $this->endSection(); ?>