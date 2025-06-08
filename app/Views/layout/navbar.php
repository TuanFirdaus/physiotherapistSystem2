<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-secondary navbar-header navbar-header-transparent navbar-expand-lg border-bottom" id="mainNav">
    <div class="container-fluid d-flex">
        <div class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <a class="navbar-brand rounded mx-5" href="/"><img src="<?= base_url('assets2/assets/img/mayLogo.png') ?>" alt="logoMay" style="width: 7vh; height: 5vh;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="/pending-appointments">Appointment</a></li>
                <li class="nav-item"><a class="nav-link" href="#Services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

                <?php if (!session()->get('loggedIn')) : ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?= session()->get('userName'); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/getProfile">My Profile</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>