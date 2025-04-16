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

    <form action="/schedule/manage" method="post">
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
                $allSlots = session()->get('allSlots');

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

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" name="action" value="edit" class="btn btn-warning me-2">Edit</button>
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
        </div>

    </form>
</div>

<?= $this->endSection(); ?>