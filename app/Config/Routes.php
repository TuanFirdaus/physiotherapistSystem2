<?php

use App\Controllers\AppointmentController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->setAutoRoute(value: true);
// $routes->get('/', 'Home::index');
// $routes->get('/try', 'Home::gettry');

// $routes->get('/manageAppointment', 'AppointmentController::getindex');;
$routes->get('/slotForm', 'AppointmentController::getSlotForm');
$routes->post('/user/login', 'User::login'); //verify login
$routes->get('/login', 'Home::getlogin'); //display login page
$routes->get('/assignSlot', 'slotController::assignSlot');
$routes->post('/assignSlot', 'slotController::assignSlot');
$routes->match(['get', 'post'], '/schedule', 'scheduleController::getSchedule');
$routes->get('/scheduleTry', 'scheduleController::getTry'); //try schedule
$routes->match(['get', 'post'], '/scheduleTest', 'scheduleController::Tryschedule'); //show manage appointment page
$routes->get('/booking', 'AppointmentController::booking');
$routes->get('/appointments', 'AppointmentController::booking');
$routes->match(['get', 'post'], '/patientTreatment', 'AppointmentController::patientTreatment');
$routes->match(['get', 'post'], '/confirmTherapist', 'AppointmentController::confirmTherapist');
// $routes->get('/check-booking', 'User::checkBooking');
// $routes->get('/redirectBooking', 'User::redirectBasedOnLogin');
$routes->post('/confirmBooking', 'AppointmentController::saveBooking');
$routes->get('/successPage', 'AppointmentController::successBooking');

// routes/web.php

// Show pending appointments page
$routes->get('/pending-appointments', 'AppointmentController::pendingAppointments');

// Handle cancel booking request
$routes->post('/cancelBooking', 'AppointmentController::cancelBooking');

// Show payment page for a specific appointment
$routes->get('/payment/(:num)', 'PaymentController::index/$1');

$routes->get('/approveApp', 'AppointmentController::listAppointment');

//delete the appointment
$routes->post('appointments/delete/(:num)', 'AppointmentController::deleteAppointment/$1');

//approve the appointment
$routes->post('appointments/approve/(:num)', 'AppointmentController::approveAppointment/$1');

$routes->get('/patientBooked', 'AppointmentController::viewAppointments');

$routes->get('/logout', 'User::logout');
$routes->match(['get', 'post'], '/register/user', 'User::registration');  // handle
$routes->get('/registerUser', 'User::getRegister'); //show

$routes->get('/adminDashboard', 'Home::adminDashboard'); //show admin dashboard

$routes->get('/manageSchedule', 'Home::manageSchedule'); //show manage schedule page

$routes->get('/therapistDetails', 'User::getTherapistDetails'); //show manage appointment page

$routes->post('/slots/delete', 'slotController::deleteSlot'); //handle manage schedule page

$routes->match(['get', 'post'], '/slots_edit', 'slotController::EditSlot'); //show edit slot page

$routes->get('/viewAppointments', 'AppointmentController::viewAllAppointments');

$routes->get('/ManageSlot', 'slotController::slotManagement'); //show all appointments page
$routes->post('/ManageSlot', 'slotController::slotManagement');
$routes->post('/slots/update', 'slotController::updateSlot');

$routes->get('/manageTherapist', 'User::manageTherapist'); // Show Manage Therapist page
$routes->get('/managePatient', 'User::managePatient'); // Show Manage Patient page
$routes->post('/updatePatient', 'User::updatePatient');
$routes->get('/deletePatient/(:num)', 'User::deletePatient/$1');
$routes->get('/manageTherapist', 'User::manageTherapist'); // Display the list of therapists
$routes->post('/updateTherapist', 'User::updateTherapist'); // Update therapist information
$routes->get('/deleteTherapist/(:num)', 'User::deleteTherapist/$1'); // Delete a therapist