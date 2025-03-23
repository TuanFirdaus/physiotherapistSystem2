<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/index');
    }

    public function getlogin()
    {
        return view('pages/login');
    }

    public function getmanageAppPatient()
    {
        echo view('manageAppointment/patient');
    }

    public function getregister()
    {
        return view('pages/register');
    }
}
