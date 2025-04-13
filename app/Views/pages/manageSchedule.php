<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">

    <h4>List of Slots</h4>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Therapist</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allSlots as $slot): ?>
                <tr>
                    <td><?= $slot['date'] ?></td>
                    <td><?= $slot['name'] ?></td>
                    <td><?= $slot['startTime'] ?></td>
                    <td><?= $slot['endTime'] ?></td>
                    <td><?= $slot['status'] ?></td>
                    <td>
                        <a href="/schedule/edit/<?= $slot['slotId'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/schedule/delete/<?= $slot['slotId'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>