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
        $recentAppointments = $this->appointmentModel->getRecentAppointment();

        // dd($recentAppointments);

        $data = [
            'labels' => array_column($treatmentStats, 'name'),
            'counts' => array_column($treatmentStats, 'total'),
            'totalUser' => $totalUser,
            'totalAppointment' => $appointmentTotal,
            'totalPendingPayments' => $totalPendingPayments,
            'totalTreatmentRecords' => $totalRecords,
            'recentAppointments' => $recentAppointments,
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

    public function therapistDashboard()
    {
        $session = session();
        $userId = $session->get('userId');
        if (!$userId || $session->get('role') !== 'therapist') {
            return redirect()->to('/login')->with('error', 'You must be logged in as a therapist.');
        }

        $therapistModel = new \App\Models\TherapistModel();
        $appointmentModel = new \App\Models\AppointmentModel();

        $therapist = $therapistModel->where('userId', $userId)->first();
        if (!$therapist) {
            return redirect()->to('/login')->with('error', 'Therapist not found.');
        }

        $user = $this->userModel->find($userId);
        $today = date('Y-m-d');

        $todayAppointments = $appointmentModel
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->where('appointment.therapistId', $therapist['therapistId'])
            ->where('slot.date', $today)
            ->countAllResults();

        $upcomingAppointments = $appointmentModel
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->where('appointment.therapistId', $therapist['therapistId'])
            ->where('slot.date >', $today)
            ->countAllResults();

        return view('pages/therapistDashboard', [
            'therapist' => $therapist,
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'user' => $user,
        ]);
    }
}
