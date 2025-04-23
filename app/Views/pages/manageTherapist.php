<!-- filepath: c:\laragon\www\physiotherapistSystem2\app\Views\pages\manageTherapist.php -->
<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h4>Manage Therapists</h4>
    <div class="row">
        <?php foreach ($therapists as $therapist): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= $therapist['profile_image'] ?>" class="card-img-top" alt="Profile Picture" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $therapist['name'] ?></h5>
                        <p class="card-text">
                            <strong>Expertise:</strong> <?= $therapist['expertise'] ?><br>
                            <strong>Availability:</strong> <?= ucfirst($therapist['availability']) ?>
                        </p>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $therapist['therapistId'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $therapist['therapistId'] ?>">
                                <li>
                                    <button class="dropdown-item" onclick="openEditTherapistModal(<?= htmlspecialchars(json_encode($therapist), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>

                                </li>
                                <li>
                                    <form action="/deleteTherapist/<?= $therapist['therapistId'] ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this therapist?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="editTherapistModal" tabindex="-1" aria-labelledby="editTherapistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/updateTherapist" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editTherapistModalLabel">Edit Therapist Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="therapistId" id="therapistId">
                    <div class="mb-3">
                        <label for="therapistName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="therapistName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="therapistExpertise" class="form-label">Expertise</label>
                        <input type="text" class="form-control" id="therapistExpertise" name="expertise" required>
                    </div>
                    <div class="mb-3">
                        <label for="therapistAvailability" class="form-label">Availability</label>
                        <select class="form-select" id="therapistAvailability" name="availability" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
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