<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6 max-w-5xl">
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Treatment Records</h2>
    <p class="text-gray-600 mb-6">View detailed treatment history for your patient</p>

    <?php if (empty($records)): ?>
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            No treatment records found for this patient.
        </div>
    <?php else: ?>
        <!-- Patient Summary -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg mb-6 border border-blue-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Patient Name</p>
                    <p class="font-medium"><?= esc($records[0]['patientName'] ?? 'Unknown') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium"><?= esc($records[0]['patientEmail'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Records</p>
                    <p class="font-medium"><?= count($records) ?></p>
                </div>
            </div>
        </div>

        <!-- Treatment History Cards -->
        <div class="space-y-6">
            <?php foreach ($records as $i => $record): ?>
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Session <?= count($records) - $i ?>
                        </h3>
                        <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded">
                            <?= date('F d, Y', strtotime($record['appointmentDate'])) ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <h4 class="font-semibold text-red-500">Diagnosis</h4>
                            <p class="bg-red-50 p-3 rounded border border-red-100 text-gray-700"><?= esc($record['diagnosis']) ?></p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-green-500">Treatment</h4>
                            <p class="bg-green-50 p-3 rounded border border-green-100 text-gray-700"><?= esc($record['treatmentName']) ?></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-semibold text-blue-500">Treatment Notes</h4>
                        <p class="bg-blue-50 p-4 rounded border border-blue-100 text-gray-700 leading-relaxed">
                            <?= esc($record['treatmentNotes']) ?>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-semibold text-purple-500">Status & Outcome</h4>
                        <div class="flex flex-col md:flex-row gap-4">
                            <span class="bg-gray-100 text-gray-800 px-3 py-2 rounded"><?= esc($record['status']) ?></span>
                            <span class="bg-purple-100 text-purple-800 px-3 py-2 rounded">Pain Rate: <?= esc($record['pain_rate'] ?? '-') ?></span>
                        </div>
                    </div>

                    <?php if (!empty($record['nextAppointment'])): ?>
                        <div>
                            <h4 class="font-semibold text-orange-500">Next Appointment</h4>
                            <p class="bg-orange-50 p-3 rounded border border-orange-100 text-gray-700">
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