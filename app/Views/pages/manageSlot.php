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
                // Retrieve all slots from the session
                $allSlots = session()->get('allSlots') ?? [];

                // Sort slots by date
                usort($allSlots, function ($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });

                // Group slots by date
                $groupedSlots = [];
                foreach ($allSlots as $slot) {
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
                            <td><?= $slot['name'] ?></td>
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
                                        $badgeClass = 'bg-warning';
                                        $statusText = 'Pending';
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

        <div class="d-flex justify-content-center mt-3">
            <!-- Form for Edit -->
            <form action="/slots_edit/<?= $slot['slotId'] ?>" method="post" class="ms-2">
                <?= csrf_field() ?>
                <input type="hidden" name="slotId" value="<?= $slot['slotId'] ?>" id="editSlotId">
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
            <!-- Form for Delete -->
            <form id="deleteForm" action="/slots_delete" method="post" class="ms-2">
                <?= csrf_field() ?>
                <input type="hidden" name="slotId" value="<?= $slot['slotId'] ?>" id="deleteSlotId">
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
            </form>
        </div>
    </form>
</div>


<?= $this->endSection(); ?>