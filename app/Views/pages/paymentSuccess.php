<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%; background: #f8fafc;">
        <div class="text-center mb-4">
            <svg width="64" height="64" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="12" fill="#4CAF50" />
                <path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <h2 class="mt-3" style="color: #388e3c;">Payment Success</h2>
            <h4>Thank you! Your payment was successful.</h4>
        </div>
        <div class="mb-4">
            <p class="mb-2"><strong>Payment Details:</strong></p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item mb-2">Name&nbsp;:&nbsp; <strong> <?= esc($name ?? 'N/A') ?></strong></li>
                <li class="list-group-item mb-2">Email&nbsp;:&nbsp; <strong> <?= esc($email ?? 'N/A') ?></strong></li>
                <li class="list-group-item mb-2">Phone&nbsp;:&nbsp; <strong> <?= esc($phone ?? 'N/A') ?></strong></li>
                <li class="list-group-item mb-2">Treatment&nbsp;:&nbsp; <strong> <?= esc($treatmentName ?? 'N/A') ?></strong></li>
                <li class="list-group-item mb-2">
                    Amount Paid&nbsp;:&nbsp;
                    <strong>
                        RM <?= esc(number_format((float)preg_replace('/[^\d.]/', '', $treatmentPrice ?? 0), 2)) ?>
                    </strong>
                </li>
                <li class="list-group-item mb-2">Date&nbsp;:&nbsp; <strong><?= esc($date ?? 'N/A') ?></strong></li>
            </ul>
        </div>
        <div class="text-center">
            <a href="<?= base_url('/') ?>" class="btn btn-success btn-lg px-5">Back to Homepage</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>