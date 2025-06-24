<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>

<div class="tw-container tw-mx-auto tw-p-6 tw-max-w-5xl">
    <h2 class="tw-text-3xl tw-font-bold tw-text-gray-900 tw-mb-2">Treatment Records - <?= esc($records[0]['patientName'] ?? 'Unknown') ?></h2>
    <p class="tw-text-gray-600 tw-mb-6">View detailed treatment history for your patient</p>

    <?php if (empty($records)): ?>
        <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow tw-text-center tw-text-gray-500">
            No treatment records found for this patient.
        </div>
    <?php else: ?>
        <!-- Patient Summary -->
        <div class="tw-bg-gradient-to-r tw-from-blue-50 tw-to-indigo-50 tw-p-4 tw-rounded-lg tw-mb-6 tw-border tw-border-blue-200">
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4">
                <div>
                    <p class="tw-text-sm tw-text-gray-600">Patient Name</p>
                    <p class="tw-font-medium"><?= esc($records[0]['patientName'] ?? 'Unknown') ?></p>
                </div>
                <div>
                    <p class="tw-text-sm tw-text-gray-600">Email</p>
                    <p class="tw-font-medium"><?= esc($records[0]['patientEmail'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="tw-text-sm tw-text-gray-600">Total Records</p>
                    <p class="tw-font-medium"><?= count($records) ?></p>
                </div>
            </div>
        </div>

        <!-- Treatment History Cards -->
        <div class="tw-space-y-6">
            <?php foreach ($records as $i => $record): ?>
                <div class="tw-bg-white tw-rounded-lg tw-shadow tw-hover:shadow-lg tw-transition-shadow tw-p-6 tw-border tw-border-gray-200">
                    <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">
                            Session <?= count($records) - $i ?>
                        </h3>
                        <span class="tw-text-sm tw-bg-blue-100 tw-text-blue-800 tw-px-3 tw-py-1 tw-rounded">
                            <?= date('F d, Y', strtotime($record['appointmentDate'])) ?>
                        </span>
                    </div>

                    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6 tw-mb-4">
                        <div>
                            <h4 class="tw-font-semibold tw-text-red-500">Diagnosis</h4>
                            <p class="tw-bg-red-50 tw-p-3 tw-rounded tw-border tw-border-red-100 tw-text-gray-700">
                                <?= esc($record['diagnosis']) ?>
                            </p>
                        </div>
                        <div>
                            <h4 class="tw-font-semibold tw-text-green-500">Treatment</h4>
                            <p class="tw-bg-green-50 tw-p-3 tw-rounded tw-border tw-border-green-100 tw-text-gray-700">
                                <?= esc($record['treatmentName']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="tw-mb-4">
                        <h4 class="tw-font-semibold tw-text-blue-500">Treatment Notes</h4>
                        <p class="tw-bg-blue-50 tw-p-4 tw-rounded tw-border tw-border-blue-100 tw-text-gray-700 tw-leading-relaxed">
                            <?= esc($record['treatmentNotes']) ?>
                        </p>
                    </div>

                    <div class="tw-mb-4">
                        <h4 class="tw-font-semibold tw-text-purple-500">Status & Outcome</h4>
                        <div class="tw-flex tw-flex-col md:tw-flex-row tw-gap-4">
                            <span class="tw-bg-gray-100 tw-text-gray-800 tw-px-3 tw-py-2 tw-rounded">
                                <?= esc($record['status']) ?>
                            </span>
                            <span class="tw-bg-purple-100 tw-text-purple-800 tw-px-3 tw-py-2 tw-rounded">
                                Pain Rate: <?= esc($record['pain_rate'] ?? '-') ?>
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($record['nextAppointment'])): ?>
                        <div>
                            <h4 class="tw-font-semibold tw-text-orange-500">Next Appointment</h4>
                            <p class="tw-bg-orange-50 tw-p-3 tw-rounded tw-border tw-border-orange-100 tw-text-gray-700">
                                <?= date('F d, Y', strtotime($record['nextAppointment'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>