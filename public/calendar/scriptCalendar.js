// Set current month and year from PHP before DOMContentLoaded
let currentMonth = window.currentMonth !== undefined ? window.currentMonth : 1; // fallback to 1 if not set
let currentYear = window.currentYear !== undefined ? window.currentYear : 2024; // fallback to 2024 if not set

document.addEventListener('DOMContentLoaded', function() {
    const prevMonthBtn = document.getElementById('prevMonthBtn');
    const nextMonthBtn = document.getElementById('nextMonthBtn');

    // Function to update the calendar for a new month
    function updateCalendar(month, year) {
        fetch(`/calendar/getCalendar?month=${month}&year=${year}`)
            .then(res => res.json())
            .then(data => {
                // Update the calendar container with new data
                document.getElementById('calendar-container').innerHTML = ''; // Clear existing content
                document.getElementById('calendar-container').insertAdjacentHTML('beforeend', data.calendarHtml); // Insert new HTML
                document.querySelector('h2').textContent = data.monthYear; // Update the month-year header
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
    console.log(data.calendarHtml);
});
