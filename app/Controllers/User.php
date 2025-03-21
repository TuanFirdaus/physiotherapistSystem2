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
        if ($user && password_verify($password, $user['password'])) {  // Password verification
            $session = session();
            $session->set([
                'loggedIn' => true,
                'userId'   => $user['userId'],
                'userName' => $user['name'],
                'role'     => $user['role'], // Store role in session
            ]);

            // Redirect based on user role
            switch ($user['role']) {
                case 'Operation Manager':
                    return redirect()->to('/approveApp');
                case 'Therapist':
                    return redirect()->to('/patientBooked');
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
        return redirect()->to('/login');
    }


    // // Method to check if user is logged in before proceeding to booking
    // public function redirectBasedOnLogin()
    // {
    //     $session = session(); // Use CodeIgniter's session instance
    //     // dd($session->get());

    //     if ($session->get('loggedIn')) {
    //         // User is logged in, redirect to the booking page
    //         return view('/booking');
    //     } else {
    //         // User is not logged in, redirect to the login page
    //         return redirect()->to('/login');
    //     }
    // }
}
