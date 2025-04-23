<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h4>Manage Patient</h4>
    <table class="table table-bordered mt-3 text-center">
        <thead class="table-dark">
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= $patient['patientId'] ?></td>
                    <td><?= $patient['name'] ?></td>
                    <td><?= $patient['address'] ?></td>
                    <td><?= $patient['phoneNo'] ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $patient['patientId'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $patient['patientId'] ?>">
                                <li>
                                    <button class="dropdown-item" onclick="openEditPatientModal(<?= htmlspecialchars(json_encode($patient), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>

                                </li>
                                <li>
                                    <form action="/deletePatient/<?= $patient['patientId'] ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/updatePatient" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="patientId" id="patientId">
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="patientName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="patientAddress" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientPhoneNo" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="patientPhoneNo" name="phoneNo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>