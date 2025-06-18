<?= $this->extend('layout/adminTemplate') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <span style="color:red"><?= isset($validation) ? $validation->showError('name') : '' ?></span>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <div class="card-header">
                <h4 class="card-title">Register Therapist</h4>
            </div>
            <div class="card-body">
                <form action="/therapist/register" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Age</label>
                        <input type="text" class="form-control" id="age" name="age" required>
                    </div>
                    <div class="form-group ">
                        <h6 class="text-black">Gender: </h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= old('gender') == 'female' ? 'checked' : ''; ?> />
                            <label class="form-check-label text-black" for="female">Female</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= old('gender') == 'male' ? 'checked' : ''; ?> />
                            <label class="form-check-label text-black" for="male">Male</label>
                        </div>
                        <span style="color:red"><?= isset($validation) ? $validation->showError('gender') : '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>