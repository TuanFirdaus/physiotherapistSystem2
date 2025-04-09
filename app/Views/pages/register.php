<?= $this->extend('layout/loginTemplate'); ?>

<?= $this->section('content'); ?>

<section class="d-flex justify-content-center align-items-center"
    style="background: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp') no-repeat center center/cover;">

    <div class="container vh-auto">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 mt-5">
                <div class="card shadow-lg p-4"
                    style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.15); 
                           box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">

                    <div class="card-body">
                        <h2 class="text-uppercase text-center text-black mb-4">Create an Account</h2>
                        <form action="/register/user" method="post">
                            <?= csrf_field() ?>
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                            <?php endif; ?>


                            <div class="form-outline mb-3">
                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <div class="text-danger"><?= $validation->getError('name'); ?></div>
                                <?php endif; ?>
                                <input type="text" id="name" name="name" value="<?= old('name'); ?>" class="form-control form-control-lg text-black" style="background: transparent; border: 1px solid black;" />
                                <label class="form-label text-black" for="name">Your Name</label>
                                <!-- Show validation error for name -->
                            </div>

                            <div class="form-outline mb-3">
                                <?php if (isset($validation) && $validation->hasError('email')): ?>
                                    <div class="text-danger"><?= $validation->getError('email'); ?></div>
                                <?php endif; ?>
                                <input type="email" id="email" name="email" value="<?= old('email'); ?>" class="form-control form-control-lg text-black" style="background: transparent; border: 1px solid black;" />
                                <label class="form-label text-black" for="email">Your Email</label>
                                <!-- Show validation error for email -->
                            </div>

                            <div class="form-outline mb-3">
                                <?php if (isset($validation) && $validation->hasError('age')): ?>
                                    <div class="text-danger"><?= $validation->getError('age'); ?></div>
                                <?php endif; ?>
                                <input type="number" id="age" name="age" value="<?= old('age'); ?>" class="form-control form-control-lg text-black" style="background: transparent; border: 1px solid black;" />
                                <label class="form-label text-black" for="age">Your Age</label>
                                <!-- Show validation error for age -->
                            </div>

                            <div class="mb-3">
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

                            <div class="form-outline mb-3">
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <div class="text-danger"><?= $validation->getError('password'); ?></div>
                                <?php endif; ?>
                                <input type="password" id="password" name="password" class="form-control form-control-lg text-black" style="background: transparent; border: 1px solid black;" />
                                <label class="form-label text-black" for="password">Password</label>
                                <!-- Show validation error for password -->
                            </div>

                            <div class="form-outline mb-3">
                                <?php if (isset($validation) && $validation->hasError('confirm-password')): ?>
                                    <div class="text-danger"><?= $validation->getError('confirm-password'); ?></div>
                                <?php endif; ?>
                                <input type="password" id="confirm-password" name="confirm-password" class="form-control form-control-lg text-black" style="background: transparent; border: 1px solid black;" />
                                <label class="form-label text-black" for="confirm-password">Repeat Password</label>
                                <!-- Show validation error for confirm password -->
                            </div>

                            <div class="form-check d-flex justify-content-center mb-4">
                                <input class="form-check-input me-2" type="checkbox" id="terms" />
                                <label class="form-check-label text-black" for="terms">
                                    I agree to the <a href="#" class="text-light"><u>Terms of Service</u></a>
                                </label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-light btn-lg px-4">Register</button>
                            </div>

                            <p class="text-center text-black mt-4">Already have an account?
                                <a href="/login" class="fw-bold text-light"><u>Login here</u></a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<?= $this->endSection(); ?>