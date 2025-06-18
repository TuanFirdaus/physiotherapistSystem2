<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container" style="height: 100vh;">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-block">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <?php
            $session = session();
            $profileImg = $session->get('profilePicture');
            $profileImg = (!empty($profileImg)) ? $profileImg : 'assets/img/defaultProfilePic.jpg';
            ?>
            <div class="card shadow-lg border-0 rounded-4  mx-auto h-100">
                <div class="card-body text-center">
                    <div class="user-profile mb-4">
                        <!-- Profile Picture -->
                        <div class="user-avatar mb-3">
                            <img src="<?= base_url($profileImg) ?>" alt="Profile Picture" class="rounded-circle shadow" width="120" height="120">
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                            <form action="<?= base_url('patient/updatePatientProfilePicture') ?>" method="post" enctype="multipart/form-data">
                                <input type="file" name="profilePicture" id="profilePicture" accept="image/*" hidden onchange="this.form.submit();">
                                <label for="profilePicture" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-upload me-1"></i> Change Picture
                                </label>
                            </form>

                            <?php if ($profileImg !== 'assets/img/defaultProfilePic.jpg'): ?>
                                <form action="<?= base_url('patient/removePatientProfilePicture') ?>" method="get" onsubmit="return confirm('Are you sure you want to remove your profile picture?');">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-trash me-1"></i> Remove Picture
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Name & Email -->
                        <h5 class="user-name mb-1"><?= esc($user['name']); ?></h5>
                        <p class="text-muted mb-0"><?= esc($user['email']); ?></p>
                    </div>

                    <!-- Patient Info -->
                    <div class="about mt-4 text-start">
                        <h5 class="text-primary text-center mb-3">Patient Information</h5>
                        <div class="row g-3">
                            <div class="col-12 d-flex align-items-center">
                                <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                <span><?= esc($patient['address']) ?></span>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <i class="fa fa-phone-alt text-success me-2"></i>
                                <span><?= esc($patient['phoneNo']) ?></span>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <i class="fa fa-venus-mars text-info me-2"></i>
                                <span><?= esc($user['gender']) ?></span>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <i class="fa fa-birthday-cake text-warning me-2"></i>
                                <span><?= esc($user['age']) ?> years old</span>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <i class="fa fa-id-card text-secondary me-2"></i>
                                <span>Patient ID: <?= esc($patient['patientCode']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <form action="<?= base_url('patient/updatePatientProfile') ?>" method="post">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="name" value="<?= esc($user['name']) ?>" placeholder="Enter full name" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input type="email" class="form-control" id="eMail" name="email" value="<?= esc($user['email']) ?>" placeholder="Enter email ID" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($patient['phoneNo'] ?? '') ?>" placeholder="Enter phone number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" value="<?= esc($user['age'] ?? '') ?>" placeholder="Enter age">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= esc($patient['address'] ?? '') ?>" placeholder="Enter address">
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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (leave blank to keep current)">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-5">
            <h5 class="mt-4 mb-3 text-primary">
                <i class="fa fa-history"></i> Recent Activity
            </h5>
            <?php if (!empty($activities)): ?>
                <table class="table table-hover table-striped">
                    <tbody>
                        <?php foreach ($activities as $activity): ?>
                            <?php
                            // Set color class based on keywords in the activity text
                            $colorClass = 'text-primary'; // default: blue
                            if (stripos($activity['activity'], 'cancelled') !== false) {
                                $colorClass = 'text-danger'; // red
                            } elseif (stripos($activity['activity'], 'success') !== false || stripos($activity['activity'], 'paid') !== false) {
                                $colorClass = 'text-success'; // green
                            }
                            ?>
                            <tr>
                                <td>
                                    <strong><?= esc($activity['username'] ?? 'You') ?></strong>
                                    <span class="<?= $colorClass ?>">
                                        <?= esc($activity['activity']) ?>
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        <?php if (isset($activity['created_at'])): ?>
                                            <?= date('F j, Y, g:i a', strtotime($activity['created_at'])) ?>
                                        <?php endif; ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent activity available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- </body>

</html> -->

<?= $this->endSection(); ?>