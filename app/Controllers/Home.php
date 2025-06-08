<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\PaymentModel;
use App\Models\treatmentRecords;

class Home extends BaseController
{
    protected $appointmentModel;
    protected $userModel;
    protected $scheduleModel;
    protected $paymentModel;
    protected $treatmentRecords;
    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
        $this->paymentModel = new PaymentModel();
        $this->treatmentRecords = new treatmentRecords();
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
        $totalUser = $this->userModel->getTotalUser();
        $appointmentTotal = $this->appointmentModel->TotalAppointment();
        $totalPendingPayments = $this->paymentModel->getTotalPendingPayments();
        $totalRecords = $this->treatmentRecords->getTotalRecords();
        $pendingCount = $this->appointmentModel->where('status', 'pending')->countAllResults();

        $data = [
            'labels' => array_column($treatmentStats, 'name'),
            'counts' => array_column($treatmentStats, 'total'),
            'totalUser' => $totalUser,
            'totalAppointment' => $appointmentTotal,
            'totalPendingPayments' => $totalPendingPayments,
            'totalTreatmentRecords' => $totalRecords,
            'pendingCount' => $pendingCount,
            'chartData' => json_encode([
                'labels' => array_column($treatmentStats, 'name'),
                'counts' => array_column($treatmentStats, 'total'),
            ])
        ];

        return view('pages/adminDashboard', $data);
    }
    public function manageSchedule()
    {
        return view('pages/manageSchedule');
    }

    public function viewAll_Appointments()
    {
        return view('pages/allAppointment');
    }

    public function getElectric()
    {
        return view('pages/electric');
    }
}
