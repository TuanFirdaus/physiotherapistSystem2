<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>

<div class="tw-container tw-mx-auto tw-p-6 tw-max-w-7xl">
    <div class="tw-mb-8">
        <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900 tw-mb-2">My Patients & Appointments</h1>
        <p class="tw-text-gray-600">Manage your patient appointments and view treatment records</p>
    </div>

    <div class="tw-overflow-x-auto tw-bg-white tw-shadow-md tw-rounded-lg tw-border tw-border-gray-200">
        <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
            <thead class="tw-bg-gray-50">
                <tr>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">#</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Patient Info</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Contact</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Appointment</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Status</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Records</th>
                    <th class="tw-px-6 tw-py-4 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="tw-divide-y tw-divide-gray-200 tw-bg-white">
                <?php foreach ($records as $index => $record): ?>
                    <?php
                    $statusClasses = [
                        'completed' => 'tw-bg-green-100 tw-text-green-800',
                        'scheduled' => 'tw-bg-blue-100 tw-text-blue-800',
                        'cancelled' => 'tw-bg-red-100 tw-text-red-800',
                    ];
                    $statusClass = $statusClasses[$record['status']] ?? 'tw-bg-gray-100 tw-text-gray-800';
                    ?>
                    <tr class="tw-hover:bg-gray-50 tw-transition-colors tw-duration-200">
                        <!-- Index -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-900"><?= $index + 1 ?></td>

                        <!-- Patient Info -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-900">
                            <div class="tw-font-semibold"><?= esc($record['patientName']) ?></div>
                        </td>

                        <!-- Contact Info -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-700">
                            <div class="tw-flex tw-items-center tw-space-x-2 tw-mb-1">
                                <i class="fas fa-envelope tw-text-gray-500"></i>
                                <span><?= esc($record['patientEmail']) ?></span>
                            </div>
                            <div class="tw-flex tw-items-center tw-space-x-2">
                                <i class="fas fa-phone tw-text-gray-500"></i>
                                <span><?= esc($record['patientPhone'] ?? '-') ?></span>
                            </div>
                        </td>

                        <!-- Appointment Date -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-700">
                            <div class="tw-flex tw-items-center tw-space-x-2">
                                <i class="fas fa-calendar-alt tw-text-gray-500"></i>
                                <span><?= date('F d, Y', strtotime($record['appointmentDate'])) ?></span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm">
                            <span class="tw-inline-block tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-font-medium <?= $statusClass ?>">
                                <?= ucfirst($record['status']) ?>
                            </span>
                        </td>

                        <!-- Records Summary -->
                        <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-700">
                            <div><strong>Diagnosis:</strong> <?= esc($record['diagnosis']) ?></div>
                            <div><strong>Treatment:</strong> <?= esc($record['treatmentName']) ?></div>
                        </td>

                        <!-- Actions -->
                        <td class="tw-px-6 tw-py-4">
                            <a href="<?= base_url('patient/viewRecords/' . $record['patientId']) ?>"
                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-1.5 tw-text-sm tw-font-medium tw-text-blue-700 tw-bg-blue-100 tw-rounded tw-hover:bg-blue-200 tw-transition">
                                <i class="fas fa-eye tw-mr-2"></i> View Records
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>