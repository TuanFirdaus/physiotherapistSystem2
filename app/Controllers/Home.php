<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;

class Home extends BaseController
{
    protected $appointmentModel;
    protected $userModel;
    protected $scheduleModel;
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
    }
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

    public function adminDashboard()
    {
        $treatmentStats = $this->appointmentModel->getTreatmentStats();

        $data = [
            'labels' => array_column($treatmentStats, 'name'),
            'counts' => array_column($treatmentStats, 'total'),
        ];
        // dd($data);

        return view('pages/adminDashboard', [
            'chartData' => json_encode($data)
        ]);
    }
    public function manageSchedule()
    {
        return view('pages/manageSchedule');
    }

    public function viewAll_Appointments()
    {
        return view('pages/allAppointment');
    }
}
