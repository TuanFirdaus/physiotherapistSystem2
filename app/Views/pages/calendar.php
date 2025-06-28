<?php $this->extend('layout/therapistTemp'); ?>

<?php $this->section('content'); ?>
<div class="container">
    <h1 class="card-title icon-calendar"> Appointment Calendar</h1>
    <div class="flex-container">
        <!-- FullCalendar container -->
        <div id="calendarContainer" class="calendar-container">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Flowbite Modal for appointment details -->
<div id="appointmentModal" class="overlay">
    <div class="overlay-content">
        <h2 id="popupTitle" class="popup-title">
            <!-- Font Awesome Icon (Calendar Check) -->
            <i class="icon-calendar"></i> Appointment Details
        </h2>
        <pre id="popupContent" class="popup-content"></pre>
        <!-- Close button -->
        <button id="closeModalBtn" class="close-btn">Close</button>
    </div>
</div>

<script>
    // Pass PHP data to JS as a global variable
    window.calendarEvents = <?= json_encode($calendarEvents) ?>;
</script>
<script src="<?= base_url('calendar/scriptCalendar.js') ?>"></script>

<?php $this->endSection(); ?>