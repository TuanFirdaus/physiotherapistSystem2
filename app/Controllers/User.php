<?php

namespace App\Controllers;


use App\Models\UserModel;
use App\Models\patientModel;
use App\Models\TreatmentModel;

class User extends BaseController
{
    protected $userModel;
    protected $patientModel; // Declare patientModel property
    protected $treatmentModel; // Declare treatmentModel property
    public function __construct()
    {
        $this->userModel = new UserModel(); // Properly instantiate the UserModel
        $this->patientModel = new PatientModel(); // Instantiate patientModel if needed\
        $this->treatmentModel = new TreatmentModel(); // Instantiate treatmentModel if needed

    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password are required.');
        }

        $user = $this->userModel->verify($email, $password);

        // Check if the user exists and the password matches
        if ($user && $password == $user['password']) {  // Password verification
            $session = session();
            $session->set([
                'loggedIn' => true,
                'userId'   => $user['userId'],
                'userName' => $user['name'],
                'role'     => $user['role'], // Store role in session
            ]);

            if ($user['role'] === 'therapist') {
                $therapist = $this->userModel->getTherapistDetailsById($user['userId']);
                if ($therapist) {
                    $session->set([
                        'therapistId'   => $therapist['therapistId'],
                        'expertise'     => $therapist['expertise'],
                        'profile_image' => $therapist['profile_image'],
                        'name'          => $therapist['name'],
                        'email'         => $therapist['email'],
                        'phoneNo'       => $therapist['phoneNo'],
                        'role'          => $user['role'],
                        'userId'        => $therapist['userId'],

                    ]);
                }
            }

            if ($user['role'] === 'Operation Manager') {
                $om = $this->userModel->getOperationManagerDetailsById($user['userId']);
                if ($om) {
                    $session->set([
                        'omId'   => $om['omId'],
                        'profile_image' => $om['profile_image'],
                        'name'          => $om['name'],
                        'email'         => $om['email'],
                        'phoneNo'       => $om['phoneNo'],
                        'address'       => $om['address'],
                        'role'          => $om['role'],
                        'userId'        => $om['userId'],
                    ]);
                }
            }

            // Set session data for patient if the user is a patient
            if ($user['role'] === 'patient') {
                $patient = $this->patientModel->getPatientDetailsByUserId($user['userId']);
                if ($patient) {
                    $session->set([
                        'patientId' => $patient['patientId'],
                        'address'   => $patient['address'],
                        'phoneNo'   => $patient['phoneNo'],
                        'profilePicture' => $patient['profilePicture'] ?? null, // Optional profile image
                    ]);
                    // dd($patient);
                }
            }

            // Redirect based on user role
            switch ($user['role']) {
                case 'Operation Manager':
                    return redirect()->to('/adminDashboard');
                case 'therapist':
                    return redirect()->to('/therapistLogin');
                case 'patient':
                    return redirect()->to('/');
                default:
                    return redirect()->to('/'); // Default page
            }
        } else {
            // If login fails, redirect back with an error message
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out successfully.');
    }

    public function getRegister()
    {
        return view('pages/register');
    }

    public function registration()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name' => [
                'label' => 'name',
                "rules" => 'required|min_length[3]|max_length[50]'
            ],
            'email' => [
                'label' => 'email',
                "rules" => 'required|valid_email|is_unique[user.email]'
            ],
            'password' => [
                'label' => 'password',
                "rules" => 'required|min_length[6]'
            ],
            'confirm-password' => [
                'label' => 'confirm-password',
                "rules" => 'matches[password]'
            ],
            'gender' => [
                'label' => 'gender',
                "rules" => 'required'
            ],
            'age' => [
                'label' => 'age',
                "rules" => 'required|integer|greater_than[0]'
            ],
        ];

        if (!$this->validate($rules)) {
            return view('pages/register', [
                'validation' => $this->validator
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'patient',
            'gender' => $this->request->getPost('gender'),
        ];


        if (!$this->userModel->insert($data)) {
            return redirect()->back()->with('error', 'Failed to register user.');
        }

        // Insert into patient table after user registration
        $userId = $this->userModel->getInsertID();
        $this->patientModel->insert([
            'userId' => $userId,
            'address' => "",
            'phoneNo' => "",
            'profilePicture' => ""
        ]);
        // Get the new patientId (auto-increment)
        $patientId = $this->patientModel->getInsertID();

        // Generate unique patient code (e.g., PAT0001)
        $patientCode = 'PAT' . str_pad($patientId, 4, '0', STR_PAD_LEFT);

        // Update the patient row with the code
        $this->patientModel->update($patientId, ['patientCode' => $patientCode]);

        return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
    }
    public function manageTherapist()
    {
        $userModel = new \App\Models\UserModel();
        $therapists = $userModel->getManageTherapists(); // Fetch therapists from the database
        // dd($therapists);


        return view('pages/manageTherapist', ['therapists' => $therapists]);
    }

    public function getRegisterTherapist()
    {
        return view('pages/registerTherapist');
    }

    public function registrationTherapist()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name' => [
                'label' => 'name',
                "rules" => 'required|min_length[3]|max_length[50]'
            ],
            'email' => [
                'label' => 'email',
                "rules" => 'required|valid_email|is_unique[user.email]'
            ],
            'password' => [
                'label' => 'password',
                "rules" => 'required|min_length[6]'
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                "rules" => 'matches[password]'
            ],
            'age' => [
                'label' => 'age',
                "rules" => 'required|integer|greater_than_equal_to[20]'
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required|min_length[10]|max_length[15]'
            ],
            'gender' => [
                'label' => 'Gender',
                'rules' => 'required|in_list[male,female]'
            ],
        ];

        if (!$this->validate($rules)) {
            return view('pages/registerTherapist', [
                'validation' => $this->validator
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'age' => $this->request->getPost('age'),
            'password' => $this->request->getPost('password'),
            'role' => 'therapist',
            'gender' => $this->request->getPost('gender'),
        ];

        // dd($data);


        $userModel = new \App\Models\UserModel();
        if (!$userModel->insert($data)) {
            return redirect()->back()->with('error', 'Failed to register therapist.');
        }
        $userId = $userModel->getInsertID();
        // . Insert into therapist table with phone
        $therapistModel = new \App\Models\therapistModel();
        $therapistData = [
            'userId' => $userId,
            'phoneNo' => $this->request->getPost('phone')
        ];

        if (!$therapistModel->insert($therapistData)) {
            return redirect()->back()->with('error', 'Failed to register therapist profile.');
        }

        return redirect()->to('/adminDashboard')->with('success', 'Registration successful! Please login.');
    }

    public function managePatient()
    {
        $userModel = new \App\Models\UserModel();
        $patients = $userModel->getManagePatients(); // Fetch patients from the database

        return view('pages/managePatient', ['patients' => $patients]);
    }

    public function updatePatient()
    {
        $patientId = $this->request->getPost('patientId');
        $name = $this->request->getPost('name');
        $address = $this->request->getPost('address');
        $phoneNo = $this->request->getPost('phoneNo');

        $patientModel = new \App\Models\PatientModel();

        // Retrieve the userId associated with the patient
        $patientDetails = $patientModel->getPatientDetails($patientId);
        if (!$patientDetails) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        $userId = $patientDetails['userId'];

        // Update the patient and user data
        $data = [
            'name' => $name,
            'address' => $address,
            'phoneNo' => $phoneNo,
        ];

        if ($patientModel->updatePatientDetails($patientId, $userId, $data)) {
            return redirect()->to('/managePatient')->with('success', 'Patient information updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update patient information.');
        }
    }

    public function deletePatient($patientId)
    {
        $patientModel = new \App\Models\PatientModel();

        if ($patientModel->delete($patientId)) {
            return redirect()->to('/managePatient')->with('success', 'Patient deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete patient.');
        }
    }

    public function updateTherapist()
    {
        $therapistId = $this->request->getPost('therapistId');
        $name = $this->request->getPost('name');
        $expertise = $this->request->getPost('expertise');
        $availability = $this->request->getPost('availability');

        $therapistModel = new \App\Models\TherapistModel();

        // Retrieve the userId associated with the therapist
        $therapistDetails = $therapistModel->getTherapistDetails($therapistId);
        if (!$therapistDetails) {
            return redirect()->back()->with('error', 'Therapist not found.');
        }

        $userId = $therapistDetails['userId'];

        // Update the therapist and user data
        $data = [
            'name' => $name,
            'expertise' => $expertise,
            'availability' => $availability,
        ];

        if ($therapistModel->updateTherapistDetails($therapistId, $userId, $data)) {
            return redirect()->to('/manageTherapist')->with('success', 'Therapist information updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update therapist information.');
        }
    }

    public function deleteTherapist($therapistId)
    {
        $therapistModel = new \App\Models\TherapistModel();

        if ($therapistModel->delete($therapistId)) {
            return redirect()->to('/manageTherapist')->with('success', 'Therapist deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete therapist.');
        }
    }

    public function getPatientDetails($patientId)
    {
        $patientModel = new PatientModel();
        $treatmentModel = new TreatmentModel();

        // Fetch patient details
        $patient = $patientModel->find($patientId);

        if ($patient) {
            // Check if the patient has treatment records
            $hasTreatmentRecords = $treatmentModel->where('patientId', $patientId)->countAllResults() > 0;

            return $this->response->setJSON([
                'success' => true,
                'patient' => $patient,
                'hasTreatmentRecords' => $hasTreatmentRecords,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Patient not found',
            ]);
        }
    }
}
