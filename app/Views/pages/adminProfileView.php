<?= $this->extend('layout/adminTemplate') ?>
<?= $this->section('content') ?>


<div class="container">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <?php
                    $session = session();
                    $profileImg = $session->get('profile_image');
                    $profileImg = (!empty($profileImg)) ? $profileImg : 'assets/img/defaultProfilePic.jpg';
                    ?>
                    <div class="account-settings card-style p-4 shadow">
                        <div class="user-profile text-center mb-4">
                            <div class="user-avatar mb-3">
                                <img src="<?= base_url($session->get('profile_image') ?? 'assets/img/defaultProfilePic.jpg') ?>"
                                    alt="profile image"
                                    class="img-fluid rounded-circle border"
                                    width="120" height="120">
                            </div>
                            <h5 class="user-name fw-bold mb-1"><?= esc($session->get('name')) ?></h5>
                            <h6 class="user-email text-muted"><?= esc($session->get('email')) ?></h6>
                        </div>

                        <div class="user-info">
                            <div class="info-block mb-3">
                                <h6 class="text-uppercase text-secondary mb-1">Address</h6>
                                <p class="mb-0"><?= esc($operationManager['address']) ?></p>
                            </div>
                            <div class="info-block mb-3">
                                <h6 class="text-uppercase text-secondary mb-1">Phone Number</h6>
                                <p class="mb-0"><?= esc($operationManager['phoneNo']) ?></p>
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
            <form action="<?= base_url('adminProfile/update') ?>" method="post">
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
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($operationManager['phoneNo']) ?>" placeholder="Enter phone number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" value="<?= esc($user['age']) ?>" placeholder="Enter phone number">
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
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street">Street</label>
                                    <input type="text" class="form-control" id="Street" name="street" placeholder="Enter Street" value="<?= esc($operationManager['street'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">City</label>
                                    <input type="text" class="form-control" id="ciTy" name="city" placeholder="Enter City" value="<?= esc($operationManager['city'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">State</label>
                                    <input type="text" class="form-control" id="sTate" name="state" placeholder="Enter State" value="<?= esc($operationManager['state'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Zip Code</label>
                                    <input type="text" class="form-control" id="zIp" name="zip" placeholder="Zip Code" value="<?= esc($operationManager['zip'] ?? '') ?>">
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
        </div>

    </div>
</div>

<?= $this->endsection() ?>