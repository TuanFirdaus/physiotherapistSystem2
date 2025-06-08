<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/css/profile.css">

    <title>User Profile</title>

</head>

<body>
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="mb-3">
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-block">
                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <?php
                $session = session();
                $profileImg = $session->get('profilePicture');
                $profileImg = (!empty($profileImg)) ? $profileImg : 'assets/img/defaultProfilePic.jpg';
                ?>
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar text-center mb-3">
                                    <img src="<?= base_url($profileImg) ?>" alt="Profile Picture" class="rounded-circle shadow" width="120" height="120">
                                </div>

                                <div class="d-flex flex-column align-items-center mb-3">
                                    <!-- Profile Picture Upload Form -->
                                    <form action="<?= base_url('patient/updatePatientProfilePicture') ?>" method="post" enctype="multipart/form-data" class="mb-2">
                                        <input type="file" name="profilePicture" id="profilePicture" accept="image/*" style="display: none;" onchange="this.form.submit();">
                                        <label for="profilePicture" class="btn btn-outline-primary btn-sm mb-1" style="width: auto;">
                                            <i class="fa fa-upload"></i> Change Picture
                                        </label>
                                    </form>
                                    <?php if ($profileImg !== 'assets/img/defaultProfilePic.jpg'): ?>
                                        <form action="<?= base_url('patient/removePatientProfilePicture') ?>" method="get" onsubmit="return confirm('Are you sure you want to remove your profile picture?');">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="width: auto;">
                                                <i class="fa fa-trash"></i> Remove Picture
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <h5 class="user-name"><?= esc($user['name']); ?></h5>
                                <h6 class="user-email"><?= esc($user['email']); ?></h6>
                            </div>
                            <div class="about">
                                <h5>Address</h5>
                                <p><?= esc($patient['address']); ?></p>
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
            <div class="col-md-12 mb-4">
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
</body>

</html>