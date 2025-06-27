<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <h1 class="card-title mb-4">Manage Therapists</h1>
    <div class="row">
        <?php foreach ($therapists as $therapist): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= base_url(!empty($therapist['profile_image']) ? esc($therapist['profile_image']) : 'assets/img/defaultProfilePic.jpg'); ?>" class="card-img-top" alt="Profile Picture" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><?= esc($therapist['name']) ?></h5>

                            <?php
                            $expertiseList = $therapist['expertise'];
                            // If it's a JSON string, decode it
                            if (is_string($expertiseList)) {
                                $decoded = json_decode($expertiseList, true);
                                $expertiseList = is_array($decoded) ? $decoded : [];
                            }
                            ?>
                            <ul class="list-unstyled mb-2 ps-0">
                                <strong>Expertise:</strong>
                                <?php foreach ($expertiseList as $skill): ?>
                                    <li class="d-inline">
                                        <span class="badge bg-primary me-1 mb-1">
                                            <?= esc(is_array($skill) && isset($skill['value']) ? $skill['value'] : $skill) ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="card-text mb-2">
                                <strong>Availability:</strong> <?= ucfirst(esc($therapist['availability'])) ?>
                            </p>
                        </div>

                        <!-- Dropdown Actions -->
                        <div class="dropdown mt-auto">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton<?= $therapist['therapistId'] ?>"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $therapist['therapistId'] ?>">
                                <li>
                                    <button class="dropdown-item"
                                        onclick="openEditTherapistModal(<?= htmlspecialchars(json_encode($therapist), ENT_QUOTES, 'UTF-8') ?>)">
                                        Edit
                                    </button>
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

<!-- Modal: Edit Therapist -->
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Trigger Script -->
<script>
    function openEditTherapistModal(data) {
        const modal = new bootstrap.Modal(document.getElementById('editTherapistModal'));
        document.getElementById('therapistId').value = data.therapistId;
        document.getElementById('therapistName').value = data.name;
        document.getElementById('therapistExpertise').value = data.expertise;
        document.getElementById('therapistAvailability').value = data.availability;
        modal.show();
    }
</script>

<?= $this->endSection(); ?>