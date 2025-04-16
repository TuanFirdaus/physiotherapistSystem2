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
        <a href="/approveApp">Manage Appointment</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">

    <h4>List of Appointments</h4>
    <form action="/schedule/manage" method="post">
        <?= csrf_field() ?>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Date</th>
                    <th>Therapist</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $allSlots = session()->get('allSlots'); ?>
                <?php foreach ($allSlots as $slot): ?>
                    <tr>
                        <td>
                            <input type="radio" name="slotId" value="<?= $slot['slotId'] ?>" required>
                        </td>
                        <td><?= $slot['date'] ?></td>
                        <td><?= $slot['name'] ?></td>
                        <td><?= $slot['startTime'] ?></td>
                        <td><?= $slot['endTime'] ?></td>
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
            </tbody>
        </table>

        <div class="mt-3">
            <button type="submit" name="action" value="edit" class="btn btn-warning">Edit</button>
            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>