<?php

use App\Controllers\AppointmentController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->setAutoRoute(value: true);

$routes->get('/slotForm', 'AppointmentController::getSlotForm');
$routes->POST('/user/login', 'User::login'); //verify login
$routes->get('/login', 'Home::getlogin'); //display login page
$routes->get('/assignSlot', 'slotController::assignSlot');
$routes->POST('/assignSlot', 'slotController::assignSlot');
$routes->match(['get', 'POST'], '/schedule', 'scheduleController::getSchedule');
$routes->get('/scheduleTry', 'scheduleController::getTry'); //try schedule
$routes->match(['get', 'POST'], '/scheduleTest', 'scheduleController::Tryschedule'); //show manage appointment page
$routes->match(['get', 'POST'], '/booking', 'AppointmentController::booking');
$routes->get('/appointments', 'AppointmentController::booking');
$routes->match(['GET', 'POST'], '/patientTreatment', 'AppointmentController::patientTreatment');
$routes->match(['GET', 'POST'], '/confirmTherapist', 'AppointmentController::confirmTherapist');
// $routes->get('/check-booking', 'User::checkBooking');
// $routes->get('/redirectBooking', 'User::redirectBasedOnLogin');
$routes->post('/confirmBooking', 'AppointmentController::confirmAndRedirect');
$routes->get('appointment/success/(:num)', 'AppointmentController::showSuccess/$1');


// routes/web.php

// Show pending appointments page
$routes->get('/pending-appointments', 'AppointmentController::pendingAppointments');

// Handle cancel booking request
$routes->POST('/cancelBooking', 'AppointmentController::cancelBooking');



$routes->get('/approveApp', 'AppointmentController::listAppointment');

//delete the appointment
$routes->POST('appointments/delete/(:num)', 'AppointmentController::deleteAppointment/$1');

//approve the appointment
$routes->POST('appointments/approve/(:num)', 'AppointmentController::approveAppointment/$1');

$routes->get('/patientBooked', 'AppointmentController::viewAppointments');

$routes->get('/logout', 'User::logout');
$routes->match(['get', 'POST'], '/register/user', 'User::registration');  // handle
$routes->get('/registerUser', 'User::getRegister'); //show

$routes->get('/adminDashboard', 'Home::adminDashboard'); //show admin dashboard

$routes->get('/manageSchedule', 'Home::manageSchedule'); //show manage schedule page

$routes->get('/therapistDetails', 'User::getTherapistDetails'); //show manage appointment page

$routes->POST('/slots/delete', 'slotController::deleteSlot'); //handle manage schedule page

$routes->match(['get', 'POST'], '/slots_edit', 'slotController::EditSlot'); //show edit slot page

$routes->get('/viewAppointments', 'AppointmentController::viewAllAppointments');

$routes->get('/ManageSlot', 'slotController::slotManagement'); //show all appointments page

$routes->POST('/ManageSlot', 'slotController::slotManagement');

$routes->POST('/slots/update', 'slotController::updateSlot');


$routes->get('/manageTherapist', 'User::manageTherapist'); // Show Manage Therapist page

$routes->get('/managePatient', 'User::managePatient'); // Show Manage Patient page

$routes->POST('/updatePatient', 'User::updatePatient');

$routes->get('/deletePatient/(:num)', 'User::deletePatient/$1');
$routes->get('/manageTherapist', 'User::manageTherapist'); // Display the list of therapists
$routes->POST('/updateTherapist', 'User::updateTherapist'); // Update therapist information
$routes->get('/deleteTherapist/(:num)', 'User::deleteTherapist/$1'); // Delete a therapist

$routes->get('/getTreatmentRecords', 'treatmentController::showTreatmentRecords'); // Show treatment records
$routes->get('/treatment', 'treatmentController::addTreatmentRecord'); // Show treatment records
$routes->get('/treatment/create', 'treatmentController::create'); // Show form to create a new treatment record
$routes->POST('/treatment/save', 'treatmentController::save'); // Save treatment record
$routes->get('/getPatientDetails/(:num)', 'treatmentController::getPatientDetails/$1');


$routes->POST('/getSuggestion', 'aiController::getSuggestion');



$routes->match(['get', 'POST'], '/payment', 'paymentController::getPayForm');
$routes->POST('payment/createBill', 'PaymentController::createBill');
$routes->get('payment/success', 'PaymentController::success');
$routes->match(['GET', 'POST'], 'payment/callback', 'PaymentController::callback');

$routes->GET('/getProfile', 'profileController::myProfile'); // Show electric page

$routes->POST('patient/updatePatientProfilePicture', 'profileController::updatePatientProfilePicture'); // Show edit profile page

$routes->GET('patient/removePatientProfilePicture', 'profileController::removePatientProfilePicture');

$routes->POST('patient/updatePatientProfile', 'profileController::updatePatientProfile'); // Handle profile update

$routes->GET('appointments/delete/(:num)', 'AppointmentController::ManageDeleteAppointment/$1');
$routes->match(['get', 'POST'], 'appointments/edit/(:num)', 'AppointmentController::ManageEditAppointment/$1');
$routes->POST('appointments/update/(:num)', 'AppointmentController::ManageUpdateAppointment/$1');


$routes->get('/adminProfile', 'adminProfileController::adminProfile'); // Show admin profile page
$routes->POST('adminProfile/update', 'adminProfileController::updateAdminProfile'); // Show edit admin profile page

$routes->GET('/registerTherapist', 'User::getRegisterTherapist'); // Show register therapist page
$routes->POST('/therapist/register', 'User::registrationTherapist'); // Handle therapist registration

$routes->get('/therapistLogin', 'Home::therapistDashboard'); // Show therapist dashboard

$routes->get('/therapistProfileView', 'therapistController::therapistProfile'); // Show therapist profile page

$routes->POST('/therapistProfile/update', 'therapistController::updateTherapistProfile'); // Handle therapist profile update

$routes->post('therapistProfile/uploadProfilePicture', 'therapistController::uploadTherapistProfilePicture');
$routes->post('therapistProfile/removeProfilePicture', 'therapistController::removeTherapistProfilePicture');

$routes->get('therapist/myPatients', 'therapistController::myPatients');
$routes->match(['get', 'post'], 'therapist/addTreatmentOutcome/(:num)', 'therapistController::addTreatmentOutcome/$1');

$routes->post('therapist/saveTreatmentOutcome', 'therapistController::saveTreatmentOutcome');
$routes->get('therapist/getTreatmentRecord/(:num)', 'therapistController::getTreatmentRecord/$1');
$routes->get('treatment-records', 'treatmentController::index');
$routes->get('patient/viewRecords/(:num)', 'treatmentController::viewByPatient/$1');

$routes->get('index/getCalendar', 'CalendarController::getCalendar');
$routes->get('/calendar/getEventDetails/(:num)', 'CalendarController::getEventDetails/$1');
$routes->get('/calendar/getAppointmentsByDay', 'CalendarController::getAppointmentsByDay');
