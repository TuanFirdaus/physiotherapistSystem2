<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\PaymentModel;
use App\Models\treatmentRecords;
use App\Models\PatientModel;
use App\Models\TherapistModel;
use App\Models\userActivityModel;

class profileController extends BaseController
{
    protected $appointmentModel;
    protected $userModel;
    protected $scheduleModel;
    protected $paymentModel;
    protected $treatmentRecords;
    protected $patientModel;
    protected $therapistModel;
    protected $activityModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
        $this->paymentModel = new PaymentModel();
        $this->treatmentRecords = new treatmentRecords();
        $this->patientModel = new PatientModel();
        $this->therapistModel = new TherapistModel();
        $this->activityModel = new userActivityModel();
    }
    // Show user profile
    public function myProfile()
    {
        $userId = session()->get('userId');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $patientModel = new PatientModel();
        $patient = $patientModel->where('userId', $userId)->first();

        $activityModel = new userActivityModel();
        $activities = $activityModel
            ->where('userId', $userId)
            ->orderBy('create_at', 'DESC')
            ->findAll();



        $data = [
            'user' => $user,
            'patient' => $patient,
            'activities' => $activities,
        ];


        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return view('pages/myProfile', $data);
    }

    // Show edit profile form
    public function editProfile()
    {
        $userId = session()->get('userId');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return view('pages/editProfile', ['user' => $user]);
    }


    //Patient Profile Picture Update and remove
    public function updatePatientProfilePicture()
    {
        $session = session();

        // Get the uploaded file
        $file = $this->request->getFile('profilePicture');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/profile_pictures/', $newName);

            // Full path to save
            $profilePath = 'uploads/profile_pictures/' . $newName;

            // Save to session (if you use it in view)
            $session->set('profilePicture', $profilePath);

            // Load the model
            $patientModel = new \App\Models\PatientModel();

            // Get patientId (either from session or via userId if necessary)
            $patientId = $session->get('patientId'); // Make sure this is set during login

            // Update DB
            $patientModel->update($patientId, [
                'profilePicture' => $profilePath
            ]);
        }

        return redirect()->back()->with('message', 'Profile picture updated successfully.');
    }


    public function removePatientProfilePicture()
    {
        $session = session();
        $userId = $session->get('userId');

        // Optionally remove the file from the server
        $currentPicture = $session->get('profilePicture');
        if ($currentPicture && file_exists($currentPicture) && $currentPicture !== 'assets/img/defaultProfilePic.jpg') {
            unlink($currentPicture);
        }

        // Set to default
        $defaultPath = 'assets/img/defaultProfilePic.jpg';

        // Update in session
        $session->set('profilePicture', $defaultPath);

        // Update in database (optional)
        $this->patientModel->where('userId', $userId)->set(['profilePicture' => $defaultPath])->update();

        return redirect()->back()->with('message', 'Profile picture removed.');
    }


    //HANDLE UPDATE PROFILE FOR PATIENTS

    public function updatePatientProfile()
    {
        $userId = session()->get('userId');
        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

        $userModel = new \App\Models\UserModel();
        $patientModel = new \App\Models\PatientModel();

        // Validate input (add more rules as needed)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required|min_length[2]',
            'email'    => 'required|valid_email',
            'phone'    => 'permit_empty',
            'age'      => 'permit_empty|integer',
            'address'  => 'permit_empty',
            'gender'   => 'permit_empty|in_list[male,female]',
            'password' => 'permit_empty|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Update user table
        $userData = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'age'    => $this->request->getPost('age'),
            'gender' => $this->request->getPost('gender'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $userData);

        // Update patient table
        $patient = $patientModel->where('userId', $userId)->first();
        $patientData = [
            'phoneNo'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];
        if ($patient) {
            $patientModel->update($patient['patientId'], $patientData);
        }
        log_user_activity(session()->get('userId'), "updated their profile on " . date('Y-m-d H:i:s'));
        return redirect()->to('/getProfile')->with('success', 'Profile updated successfully.');
    }
}
