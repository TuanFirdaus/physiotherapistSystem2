document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            events: window.calendarEvents,  // Use global JS variable for events
            editable: false,
            droppable: false,

            // Handle day click event
            dayClick: function(date, jsEvent, view) {
                jsEvent.preventDefault(); // Prevent default behavior

                // Get the clicked date
                var clickedDate = date.format('YYYY-MM-DD');
                var appointmentsForDay = window.calendarEvents.filter(function(appointment) {
                    return appointment.start.startsWith(clickedDate);
                });

                // Display appointments or no appointments
                if (appointmentsForDay.length > 0) {
                    var details = '';
                    appointmentsForDay.forEach(function(appointment) {
                        details += (appointment.className === 'available' ?
                                'Available Slot\n' :
                                'Patient: ' + appointment.patientName + '\nTreatment: ' + appointment.treatment + '\n') +
                            'Time: ' + appointment.startTime + ' - ' + appointment.endTime + '\n\n';
                    });
                    showAppointmentCard('Appointments for ' + clickedDate, details);
                } else {
                    showAppointmentCard('No Appointments', 'There are no appointments for this day.');
                }
            },

            // Handle event click
            eventClick: function(calEvent) {
                var details = (calEvent.className === 'available' ?
                        'Available Slot\n' :
                        'Patient: ' + calEvent.patientName + '\nTreatment: ' + calEvent.treatment + '\n') +
                    'Time: ' + calEvent.startTime + ' - ' + calEvent.endTime;
                showAppointmentCard('Appointment Details', details);
            }
        });
    });

    // Function to show the modal and populate it with appointment details
    function showAppointmentCard(title, content) {
        var modal = document.getElementById('appointmentModal');
        var cardTitle = document.getElementById('popupTitle');
        var cardContent = document.getElementById('popupContent');

        // Log for debugging
        console.log("Show modal", modal, cardTitle, cardContent);

        // Check if modal and content elements exist before attempting to modify them
        if (modal && cardTitle && cardContent) {
            cardTitle.innerText = title;
            cardContent.innerText = content;
            modal.style.display = 'block'; // Show the modal by directly changing the display property
        } else {
            console.error("Modal or content elements are missing.");
        }
    }

    // Function to close the modal
    function closeAppointmentCard() {
        var modal = document.getElementById('appointmentModal');
        if (modal) {
            modal.style.display = 'none'; // Close modal by setting display to none
        } else {
            console.error("Modal element is missing.");
        }
    }

    // Ensure the close button works
    var closeModalBtn = document.getElementById('closeModalBtn');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeAppointmentCard); // Attach close function to the button
    }

    // Optional: Close modal when clicking outside the card
    $(document).on('mousedown', function(event) {
        var $modalContent = $('#appointmentModal .overlay-content');
        if ($('#appointmentModal').is(':visible') && !$modalContent.is(event.target) && $modalContent.has(event.target).length === 0) {
            closeAppointmentCard();
        }
    });
});
