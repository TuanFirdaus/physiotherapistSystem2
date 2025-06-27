<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<h2><?= esc($monthYear) ?></h2>
<div id="calendar-container">
    <?= $calendarHtml ?>
</div>

<div id="event-details" style="margin-top:20px; border-top:1px solid #ccc; padding-top:10px;">
    <em>Click an event to view details.</em>
</div>

<script>
    // JavaScript to handle event click
    document.querySelectorAll('.event-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const eventId = this.getAttribute('data-id');

            // Fetch event details
            fetch(`/calendar/getEventDetails/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    const detailsContainer = document.getElementById('event-details');
                    detailsContainer.innerHTML = `
                        <h3>${data.title}</h3>
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Start Date:</strong> ${data.start_date}</p>
                        <p><strong>End Date:</strong> ${data.end_date}</p>
                        <p><strong>Therapist:</strong> ${data.therapist.name}</p>
                        <p><strong>Patient:</strong> ${data.patient.name}</p>
                        <p><strong>User:</strong> ${data.user.name}</p>
                    `;
                });
        });
    });
</script>

<?= $this->endSection() ?>