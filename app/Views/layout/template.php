<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="assets/img/kaiadmin/favicon.ico"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
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
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />


    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets2/css/styles.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- style utk cTherapist -->
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        /* Hover Effect for Cards */
        .therapist-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .therapist-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Bounce Animation for Clicks */
        .therapist-card:active {
            transform: translateY(-5px) scale(0.98);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Fade-in Animation for Entry */
        .animate-card {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Keyframes for Fade-in */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>



</head>

<body id="page-top">


    <div class="wrapper" style="height: 100vh;">
        <?= $this->include('layout/navbar'); ?>
        <div class="" style="margin-top: 100px;">
            <?= $this->renderSection('content'); ?>
        </div>

        <!-- Footer-->
        <!-- <footer class="footer py-4">
          
        </footer> -->
        <?= $this->include('layout/footer'); ?>



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

    <!-- Bootstrap core JS-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/assets2/js/bootstrap.bundle.min.js"></script> -->
    <!-- Core theme JS-->
    <script src="assets2/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>

    <!-- Bootstrap Bundle (JS + Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!-- admin script -->
    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(1)");
        active.classList.add("active");
    </script>

</body>

</html>