document.addEventListener('DOMContentLoaded', function () {
    const calendarContainer = document.getElementById('calendar-container');
    const detailsContainer = document.getElementById('event-details');

    // Listen for clicks on calendar cells
    document.addEventListener('click', function (e) {
        if (e.target.closest('.calendar-cell')) {
            const cell = e.target.closest('.calendar-cell');
            const day = cell.dataset.day;
            const month = cell.dataset.month;
            const year = cell.dataset.year;

            // Fetch appointments for this day
            fetch(`/calendar/getAppointmentsByDay?day=${day}&month=${month}&year=${year}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = `<h3>Appointments on ${year}-${month}-${day}</h3><ul>`;
                        data.forEach(item => {
                            html += `<li><a href='#' class='event-link' data-id='${item.scheduleId}'>${item.treatmentName} (ID: ${item.appointmentId})</a></li>`;
                        });
                        html += '</ul>';
                        detailsContainer.innerHTML = html;
                    } else {
                        detailsContainer.innerHTML = `<h3>No appointments on ${year}-${month}-${day}</h3>`;
                    }
                })
                .catch(err => {
                    detailsContainer.innerHTML = `<p style="color:red;">Error loading appointments</p>`;
                    console.error(err);
                });
        }
    });
});
