<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('breadcrumbs'); ?>
<ul class="page-breadcrumb">
    <li class="nav-home">
        <a href="/adminDashboard" class="nav-link">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/slot/manage">Manage Slot</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h4>Timetable of Slots</h4>

    <!-- Buttons placed at the top-right -->
    <div class="d-flex justify-content-end mb-3">
        <!-- Edit Button -->
        <form action="/slots_edit" method="post" class="me-2">
            <?= csrf_field() ?>
            <input type="hidden" name="slotId" id="editSlotId">
            <button type="submit" class="btn btn-warning btn-sm">Edit Selected Slot</button>
        </form>

        <!-- Delete Button -->
        <form action="/slots/delete" method="post" onsubmit="return confirm('Are you sure you want to delete this slot?');">
            <?= csrf_field() ?>
            <input type="hidden" name="slotId" id="deleteSlotId">
            <button type="submit" class="btn btn-danger btn-sm">Delete Selected Slot</button>
        </form>
    </div>

    <form id="slotForm">
        <?= csrf_field() ?>
        <!-- Timetable -->
        <table class="table table-bordered mt-3 text-center">
            <thead class="table-dark">
                <tr>
                    <th>Select</th>
                    <th>Therapist</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve slots from the session
                $slotsData = session()->get('slotsData') ?? [];

                // Sort slots by date
                usort($slotsData, function ($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });

                // Group slots by date
                $groupedSlots = [];
                foreach ($slotsData as $slot) {
                    $groupedSlots[$slot['date']][] = $slot;
                }

                // Display slots grouped by date
                foreach ($groupedSlots as $date => $slots): ?>
                    <tr>
                        <td colspan="6" class="table-primary text-center"><strong><?= $date ?></strong></td>
                    </tr>
                    <?php foreach ($slots as $slot): ?>
                        <tr>
                            <td>
                                <input type="radio" name="slotId" value="<?= $slot['slotId'] ?>" required>
                            </td>
                            <td><?= $slot['therapistName'] ?></td>
                            <td><?= $slot['startTime'] ?> - <?= $slot['endTime'] ?></td>
                            <td>
                                <?php
                                $badgeClass = '';
                                $statusText = '';

                                switch ($slot['status']) {
                                    case 'booked':
                                        $badgeClass = 'bg-success';
                                        $statusText = 'Booked';
                                        break;
                                    case 'cancelled':
                                        $badgeClass = 'bg-danger';
                                        $statusText = 'Cancelled';
                                        break;
                                    default:
                                        $badgeClass = 'bg-info';
                                        $statusText = 'Available';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>
<?= $this->endSection(); ?>