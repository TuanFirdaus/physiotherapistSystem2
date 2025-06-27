<?= $this->extend('layout/therapistTemp') ?>

<?= $this->section('content') ?>

<h2><?= esc($monthYear) ?></h2>

<!-- Buttons for Previous and Next Month -->
<div style="text-align: center; margin-bottom: 20px;">
    <button id="prevMonthBtn" class="btn btn-primary">Previous Month</button>
    <button id="nextMonthBtn" class="btn btn-primary">Next Month</button>
</div>

<!-- Calendar Table -->
<div id="calendar-container">
    <?= $calendarHtml ?>
</div>

<!-- Event Details Section -->
<div id="event-details" style="margin-top:20px; border-top:1px solid #ccc; padding-top:10px;">
    <em>Click a date to see appointment details.</em>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevMonthBtn = document.getElementById('prevMonthBtn');
        const nextMonthBtn = document.getElementById('nextMonthBtn');

        let currentMonth = <?= $month ?>; // Set current month from PHP
        let currentYear = <?= $year ?>; // Set current year from PHP

        // Function to update the calendar for a new month
        function updateCalendar(month, year) {
            fetch(`/calendar/getCalendar?month=${month}&year=${year}`)
                .then(res => res.json())
                .then(data => {
                    // Update the calendar container with new data
                    document.getElementById('calendar-container').innerHTML = data.calendarHtml;
                    document.querySelector('h2').textContent = data.monthYear;
                });
        }

        // When "Previous Month" is clicked
        prevMonthBtn.addEventListener('click', function() {
            // Go to previous month
            if (currentMonth === 1) {
                currentMonth = 12;
                currentYear -= 1;
            } else {
                currentMonth -= 1;
            }
            updateCalendar(currentMonth, currentYear);
        });

        // When "Next Month" is clicked
        nextMonthBtn.addEventListener('click', function() {
            // Go to next month
            if (currentMonth === 12) {
                currentMonth = 1;
                currentYear += 1;
            } else {
                currentMonth += 1;
            }
            updateCalendar(currentMonth, currentYear);
        });
    });
</script>

<?= $this->endSection() ?>