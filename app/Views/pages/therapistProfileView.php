<?= $this->extend('layout/therapistTemp') ?>
<?= $this->section('content') ?>

<!-- Load Tagify CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<div class="container">
    <div class="row gutters">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="success-alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-auto">
                <div class="card-body">
                    <?php
                    $session = session();
                    $profileImg = $session->get('profile_image');
                    $profileImg = (!empty($profileImg)) ? $profileImg : 'assets/img/defaultProfilePic.jpg';
                    ?>
                    <div class="account-settings card-style shadow py-4">
                        <div class="user-profile text-center mb-4">
                            <div class="user-avatar mb-3">
                                <img src="<?= base_url($profileImg) ?>"
                                    alt="profile image"
                                    class="img-fluid rounded-circle border"
                                    width="120" height="120">
                            </div>
                            <!-- Upload Profile Picture Button -->
                            <form action="<?= base_url('therapistProfile/uploadProfilePicture') ?>" method="post" enctype="multipart/form-data" class="d-inline">
                                <input type="file" name="profilePicture" id="profilePicture" accept="image/*" hidden onchange="this.form.submit();">
                                <label for="profilePicture" class="btn btn-outline-primary btn-sm mb-2">
                                    <i class="fa fa-upload me-1"></i> Change Picture
                                </label>
                            </form>
                            <!-- Remove Profile Picture Button -->
                            <?php
                            $defaultImg = 'assets/img/defaultProfilePic.jpg';
                            if (!empty($session->get('profile_image')) && $session->get('profile_image') !== $defaultImg):
                            ?>
                                <form action="<?= base_url('therapistProfile/removeProfilePicture') ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to remove your profile picture?');">
                                    <button type="submit" class="btn btn-outline-danger btn-sm mb-2">
                                        <i class="fa fa-trash me-1"></i> Remove Picture
                                    </button>
                                </form>
                            <?php endif; ?>
                            <h5 class="user-name fw-bold mb-1"><?= esc($session->get('name')) ?></h5>
                            <h6 class="user-email text-muted"><?= esc($session->get('email')) ?></h6>
                        </div>

                        <div class="user-info mb-4 me-4 ms-2">
                            <div class="info-block mb-3 justify-content-center align-items-center">
                                <h6 class="text-uppercase text-secondary mb-1">Expertise</h6>
                                <?php
                                $expertiseList = json_decode($therapist['expertise'] ?? '[]', true);
                                if (is_array($expertiseList)) {
                                    foreach ($expertiseList as $item) {
                                        if (isset($item['value']) && trim($item['value'])) {
                                            echo '<span class="badge bg-primary mb-1">' . esc($item['value']) . '</span>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="info-block mb-3">
                                <h6 class="text-uppercase text-secondary mb-1">Phone Number</h6>
                                <p class="mb-0"><?= esc($therapist['phoneNo'] ?? 'N/A') ?></p>
                            </div>
                            <div class="info-block">
                                <h6 class="text-uppercase text-secondary mb-1">Role</h6>
                                <p class="mb-0"><?= esc($session->get('role')) ?></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <form action="<?= base_url('therapistProfile/update') ?>" method="post">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Personal Details</h6>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['name']) ?>" placeholder="Enter full name">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" placeholder="Enter email ID">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($therapist['phoneNo'] ?? '') ?>" placeholder="Enter phone number">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" value="<?= esc($user['age']) ?>" placeholder="Enter age">
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="male" <?= (isset($user['gender']) && $user['gender'] == 'male') ? 'selected' : '' ?>>Male</option>
                                        <option value="female" <?= (isset($user['gender']) && $user['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tag input for expertise -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="expertise">Expertise</label>
                                    <input type="text" class="form-control" id="expertise" name="expertise" placeholder="Type and press enter" value="<?= esc($therapist['expertise'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (leave blank to keep current)">
                                </div>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary ms-3">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Activity</h5>
                    <ul class="list-unstyled">
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <li class="mb-3 d-flex align-items-start">
                                    <span class="me-2 mt-1" style="color:#2563eb;"><i class="fas fa-circle fa-xs"></i></span>
                                    <div>
                                        <strong><?= esc($activity['activity']) ?></strong><br>
                                        <small class="text-muted">
                                            <?= time_elapsed_string($activity['create_at']) ?>
                                        </small>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="text-muted">No recent activity.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Initialize Tagify
    var input = document.querySelector('#expertise');
    new Tagify(input);
</script>
<script>
    // Auto-dismiss alert after 3 seconds (3000 ms)
    setTimeout(function() {
        var alert = document.getElementById('success-alert');
        if (alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
</script>
<?= $this->endsection() ?>