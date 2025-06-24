<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6 max-w-7xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Patients & Appointments</h1>
        <p class="text-gray-600">Manage your patient appointments and view treatment records</p>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">#</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Patient Info</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Contact</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Appointment</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Records</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php foreach ($records as $index => $record): ?>
                    <?php
                    $statusClasses = [
                        'completed' => 'bg-green-100 text-green-800',
                        'scheduled' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusClass = $statusClasses[$record['status']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <!-- Index -->
                        <td class="px-6 py-4 text-sm text-gray-900"><?= $index + 1 ?></td>

                        <!-- Patient Info -->
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="font-semibold"><?= esc($record['patientName']) ?></div>
                        </td>

                        <!-- Contact Info -->
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex items-center space-x-2 mb-1">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <span><?= esc($record['patientEmail']) ?></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-gray-500"></i>
                                <span><?= esc($record['patientPhone'] ?? '-') ?></span>
                            </div>
                        </td>

                        <!-- Appointment Date -->
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-alt text-gray-500"></i>
                                <span><?= date('F d, Y', strtotime($record['appointmentDate'])) ?></span>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium <?= $statusClass ?>">
                                <?= ucfirst($record['status']) ?>
                            </span>
                        </td>

                        <!-- Records Summary -->
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div><strong>Diagnosis:</strong> <?= esc($record['diagnosis']) ?></div>
                            <div><strong>Treatment:</strong> <?= esc($record['treatmentName']) ?></div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <a href="<?= base_url('patient/viewRecords/' . $record['patientId']) ?>"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 transition">
                                <i class="fas fa-eye mr-2"></i> View Records
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>

<?= $this->endSection() ?>