<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Physioterapy Admin Dashboard</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />



    <!-- Fonts and icons -->
    <script src="<?= base_url('assets/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= base_url('assets/css/fonts.min.css') ?>"],

            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <link rel="stylesheet" href="<?= base_url('assets/css/adminProfile.css') ?>">



    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/plugins.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/kaiadmin.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets2/css/reg.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets2/css/adminDashboard.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets2/css/manageSlot.css') ?>" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.output.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


</head>

<body>


    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <?= $this->include('layout/adminNav'); ?>
        </div>
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="main-header">
                <?= $this->include('layout/adminHeader'); ?>
                <!-- End Navbar -->
            </div>
            <div class="container">
                <!-- breadcrumbs section -->
                <div class="breadcrumbs mb-5">
                    <?= $this->renderSection('breadcrumbs'); ?>
                </div>
                <div class="page-inner">
                    <?= $this->renderSection('content'); ?>
                </div>
            </div>

            <!-- Footer-->
            <footer class="footer mt-auto py-3 bg-dark text-light border-top shadow-sm">
                <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <span class="fw-bold">PhysioClinic System</span> &copy; <?= date('Y') ?>
                        <span class="ms-2">Made by Tuan Mohamad Firdaus</span>
                    </div>
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link px-2 text-light" href="#">Help</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 text-light" href="#">Licenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 text-light" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </footer>


        </div>

    </div>






    <!-- Core JS Files -->
    <script src="<?= base_url('assets/js/core/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
    <!-- <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script> -->

    <!-- jQuery Scrollbar -->
    <script src="<?= base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>

    <!-- Chart JS -->
    <script src="<?= base_url('assets/js/plugin/chart.js/chart.min.js') ?>"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= base_url('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') ?>"></script>

    <!-- Chart Circle -->
    <script src="<?= base_url('assets/js/plugin/chart-circle/circles.min.js') ?>"></script>

    <!-- Datatables -->
    <script src="<?= base_url('assets/js/plugin/datatables/datatables.min.js') ?>"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?= base_url('assets/js/plugin/jsvectormap/jsvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugin/jsvectormap/world.js') ?>"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url('assets/js/plugin/sweetalert/sweetalert.min.js') ?>"></script>

    <!-- Kaiadmin JS -->
    <script src="<?= base_url('assets/js/kaiadmin.min.js') ?>"></script>



    <!-- Bootstrap Bundle (JS + Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- graph Section -->
    <!-- Include Chart.js library -->
    <script src="<?= base_url('assets2/js/chart.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // JavaScript to handle radio button selection for Edit and Delete
        document.querySelectorAll('input[name="slotId"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('editSlotId').value = this.value;
                document.getElementById('deleteSlotId').value = this.value;
            });
        });

        // SweetAlert2 confirmation dialog for delete action
        function confirmDelete() {
            const deleteForm = document.getElementById('deleteForm');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your slot has been deleted.',
                        'success'
                    );
                    // Submit the form after confirmation
                    deleteForm.submit();
                }
            });
        }
    </script>

    <script>
        // Function to open the modal and populate it with patient data
        // For patient modal
        function openEditPatientModal(patient) {
            document.getElementById('patientId').value = patient.patientId;
            document.getElementById('patientName').value = patient.name;
            document.getElementById('patientAddress').value = patient.address;
            document.getElementById('patientPhoneNo').value = patient.phoneNo;

            var editPatientModal = new bootstrap.Modal(document.getElementById('editPatientModal'));
            editPatientModal.show();
        }

        // For therapist modal
        function openEditTherapistModal(therapist) {
            document.getElementById('therapistId').value = therapist.therapistId;
            document.getElementById('therapistName').value = therapist.name;
            document.getElementById('therapistExpertise').value = therapist.expertise;
            document.getElementById('therapistAvailability').value = therapist.availability;

            var editTherapistModal = new bootstrap.Modal(document.getElementById('editTherapistModal'));
            editTherapistModal.show();
        }


        // SweetAlert for session flash messages
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>