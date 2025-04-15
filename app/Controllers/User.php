<?php

namespace App\Controllers;


use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel(); // Properly instantiate the UserModel

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
                    ]);
                }
            }

            // Redirect based on user role
            switch ($user['role']) {
                case 'Operation Manager':
                    return redirect()->to('/adminDashboard');
                case 'therapist':
                    return redirect()->to('/adminDashboard');
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
        return redirect()->to('/');
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

        return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
    }
}
