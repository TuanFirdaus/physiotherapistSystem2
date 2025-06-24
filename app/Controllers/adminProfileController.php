<?php

namespace App\Controllers;

use App\Models\userModel;
use App\Models\PatientModel;
use App\Models\TherapistModel;
use App\Models\operationManagerModel;

class adminProfileController extends BaseController
{
    protected $userModel;
    protected $patientModel;
    protected $therapistModel;
    protected $operationManagerModel;
    public function __construct()
    {
        $this->userModel = new userModel();
        $this->patientModel = new PatientModel();
        $this->therapistModel = new TherapistModel();
        $this->operationManagerModel = new operationManagerModel();
    }

    // Show admin profile
    public function adminProfile()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        $operationManagerModel = $this->operationManagerModel->where('userId', $userId)->first();


        // dd($operationManagerModel);
        // Get patient and therapist details if applicable

        $therapist = $this->therapistModel->where('userId', $userId)->first();

        $data = [
            'user' => $user,
            'therapist' => $therapist,
            'operationManager' => $operationManagerModel,
        ];

        return view('pages/adminProfileView', $data);
    }



    // Update admin profile
    public function updateAdminProfile()
    {
        $userId = session()->get('userId');
        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required|min_length[2]',
            'email'    => 'required|valid_email',
            'phone'    => 'permit_empty',
            'age'      => 'permit_empty|integer',
            'gender'   => 'permit_empty|in_list[male,female]',
            'password' => 'permit_empty|min_length[6]',
            'street'   => 'permit_empty',
            'city'     => 'permit_empty',
            'state'    => 'permit_empty',
            'zip'      => 'permit_empty',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Prepare user data
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

        $this->userModel->update($userId, $userData);

        // Combine address fields
        $street = $this->request->getPost('street');
        $city   = $this->request->getPost('city');
        $state  = $this->request->getPost('state');
        $zip    = $this->request->getPost('zip');
        $address = trim("{$street}, {$city}, {$state} {$zip}");

        // Update operation manager table (admin details)
        $operationManager = $this->operationManagerModel->where('userId', $userId)->first();
        $adminData = [
            'phoneNo' => $this->request->getPost('phone'),
            'address' => $address,
        ];
        if ($operationManager) {
            $this->operationManagerModel->update($operationManager['omId'], $adminData);
        }
        log_user_activity(session()->get('userId'), "updated your profile on " . date('Y-m-d H:i:s'));
        // Optionally log activity here

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
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
}
