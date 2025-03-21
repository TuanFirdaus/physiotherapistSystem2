<?= $this->extend('layout/loginTemplate') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="col d-flex ">
        <div class="row mx-auto border border-5 justify-content-center">
            <form action="/user/login" class="justify-content-center" method="post">
                <!-- Display error message if it exists -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control " id="email" placeholder="Enter Email">
                    <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control " id="password" placeholder="Enter your password">
                    <a href="#" class="form-text text-muted">Forgot Password?</a>
                </div>

                <div class="row d-flex justify-content-center gap-1">
                    <button type="submit" class="btn btn-success w-50 mb-3 mt-3">Log in</button>
                    <a href="/register" class="btn btn-warning w-50 mb-4">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>