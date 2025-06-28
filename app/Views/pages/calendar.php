<?php $this->extend('layout/therapistTemp'); ?>

<?php $this->section('content'); ?>
<div class="tw-container tw-mx-auto tw-p-6 tw-max-w-5xl">
    <h1 class="tw-text-3xl tw-font-semibold tw-mb-4">Physiotherapy Appointments</h1>

    <!-- FullCalendar container with Tailwind styling -->
    <div id="calendarContainer" class="tw-bg-white tw-shadow-lg tw-rounded-lg tw-p-4 tw-relative">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal for appointment details -->
<div id="appointmentModal" class="tw-hidden tw-absolute tw-z-50 tw-bg-white tw-rounded-lg tw-shadow-xl tw-p-6 tw-w-1/3 tw-max-w-xs tw-transition-all tw-duration-300 tw-opacity-0">
    <h2 id="modalTitle" class="tw-text-xl tw-font-bold tw-mb-2">Appointment Details</h2>
    <pre id="modalContent" class="tw-text-lg tw-mb-4 tw-whitespace-pre-line"></pre>
    <button onclick="closeModal()"
        class="tw-bg-blue-500 tw-text-white tw-px-4 tw-py-2 tw-rounded hover:tw-bg-blue-600">
        Close
    </button>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fullcalendar.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            events: [
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?> {
                            title: "<?= esc($appointment['patient_name']) ?> - <?= esc($appointment['treatment']) ?>",
                            start: "<?= esc($appointment['date']) . 'T' . esc($appointment['start_time']) ?>",
                            end: "<?= esc($appointment['date']) . 'T' . esc($appointment['end_time']) ?>",
                            className: 'event'
                        },
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            editable: false,
            droppable: false,
            dayClick: function(date, jsEvent, view) {
                // Prevent default behavior on day click
                jsEvent.preventDefault();

                // Get the selected date
                var clickedDate = date.format('YYYY-MM-DD');
                var appointmentsForDay = <?php echo json_encode($appointments); ?>.filter(function(appointment) {
                    return appointment.date === clickedDate;
                });

                // If there are appointments for that day, show the modal
                if (appointmentsForDay.length > 0) {
                    var details = '';
                    appointmentsForDay.forEach(function(appointment) {
                        details += 'Patient: ' + appointment.patient_name + '\n';
                        details += 'Treatment: ' + appointment.treatment + '\n';
                        details += 'Time: ' + appointment.start_time + ' - ' + appointment.end_time + '\n\n';
                    });
                    showModal('Appointments for ' + clickedDate, details, jsEvent);
                } else {
                    // If no appointments, display a message
                    showModal('No Appointments', 'There are no appointments for this day.', jsEvent);
                }
            }
        });
    });

    function showModal(title, content, jsEvent) {
        var modal = document.getElementById('appointmentModal');
        var modalTitle = document.getElementById('modalTitle');
        var modalContent = document.getElementById('modalContent');

        modalTitle.innerText = title;
        modalContent.innerText = content;

        // Position the modal near the clicked event
        modal.style.left = jsEvent.pageX + 'px';
        modal.style.top = jsEvent.pageY + 'px';

        // Show the modal with a smooth transition
        modal.classList.remove('tw-hidden');
        modal.classList.add('tw-opacity-100');
    }

    function closeModal() {
        var modal = document.getElementById('appointmentModal');
        modal.classList.add('tw-hidden');
        modal.classList.remove('tw-opacity-100');
    }
</script>

<?php $this->endSection(); ?>