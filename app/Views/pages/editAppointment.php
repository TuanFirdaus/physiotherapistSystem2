<?= $this->extend('layout/adminTemplate'); ?>

<?= $this->section('breadcrumbs'); ?>
<ul class="page-breadcrumb">
    <li class="nav-home">
        <a href="/adminDashboard" class="nav-link">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item">
        <a href="/">Edit Appointment</a>
    </li>
</ul>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">



</div>

<?= $this->endSection(); ?>