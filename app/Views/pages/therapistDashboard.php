<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>
<div class="tw-space-y-6">
    <div>
        <h2 class="tw-text-3xl tw-font-bold tw-text-gray-900">Welcome back, Master <?= esc($user['name']) ?></h2>
        <p class="tw-text-gray-600">Here's what's happening with your dashboard today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6">
        <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600">Today's Appointments</p>
                    <p class="tw-text-2xl tw-font-bold"><?= $today_appointments ?></p>
                    <p class="tw-text-sm tw-text-gray-500">3 upcoming</p>
                </div>
                <i class="fas fa-calendar tw-text-blue-600"></i>
            </div>
        </div>

        <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600">Active Patients</p>
                    <p class="tw-text-2xl tw-font-bold"><?= $total_patients ?></p>
                    <p class="tw-text-sm tw-text-gray-500">+12 this month</p>
                </div>
                <i class="fas fa-users tw-text-green-600"></i>
            </div>
        </div>
        <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <p class="tw-text-sm tw-font-medium tw-text-gray-600">Session Hours</p>
                    <p class="tw-text-2xl tw-font-bold"><strong><?= $weekly_hours ?></strong></p>
                    <p class="tw-text-sm tw-text-gray-500">This week</p>
                </div>
                <i class="fas fa-clock tw-text-purple-600"></i>
            </div>
        </div>

        <!-- Add more stat cards as needed -->
    </div>

    <!-- Today's Schedule -->
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">
        <div class="tw-bg-white tw-rounded-lg tw-shadow">
            <div class="tw-p-6 tw-border-b">
                <h3 class="tw-text-lg tw-font-semibold">Today's Schedule</h3>
                <p class="tw-text-sm tw-text-gray-600">Your upcoming appointments</p>
            </div>
            <div class="tw-p-6">
                <?php if (!empty($upcoming_appointments)): ?>
                    <?php foreach ($upcoming_appointments as $appointment): ?>
                        <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-bg-gray-50 tw-rounded-lg tw-mb-3">
                            <div>
                                <div class="tw-font-medium"><?= esc($appointment['patient_name']) ?></div>
                                <div class="tw-text-sm tw-text-gray-600"><?= esc($appointment['type']) ?></div>
                            </div>
                            <div class="tw-text-sm tw-font-medium tw-text-blue-600">
                                <?= date('g:i A', strtotime($appointment['appointment_time'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="tw-text-gray-500">No appointments scheduled for today.</p>
                <?php endif; ?>
                <a href="<?= base_url('index/getCalendar') ?>"
                    class="tw-w-full tw-mt-4 tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-rounded-md hover:tw-bg-gray-50 tw-inline-block tw-text-center">
                    View Full Schedule
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="tw-bg-white tw-rounded-lg tw-shadow">
            <div class="tw-p-6 tw-border-b">
                <h3 class="tw-text-lg tw-font-semibold">Recent Activity</h3>
                <p class="tw-text-sm tw-text-gray-600">Latest updates from your practice</p>
            </div>
            <div class="tw-p-6">
                <?php foreach ($recent_activities as $activity): ?>
                    <div class="tw-flex tw-items-start tw-space-x-3 tw-mb-4 <?= esc($activity['color']) ?> tw-p-3 tw-rounded-md">
                        <i class="<?= esc($activity['icon']) ?> tw-mt-1"></i>
                        <div>
                            <p class="tw-text-sm"><?= esc($activity['message']) ?></p>
                            <p class="tw-text-xs tw-text-gray-500"><?= esc($activity['time']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>