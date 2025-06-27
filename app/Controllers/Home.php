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
        helper('time');
        $session = session();
        $userId = $session->get('userId');

        if (!$userId || $session->get('role') !== 'therapist') {
            return redirect()->to('/login')->with('error', 'You must be logged in as a therapist.');
        }

        $therapistModel = new \App\Models\therapistModel();
        $appointmentModel = new \App\Models\AppointmentModel();
        $slotModel = new \App\Models\slotModel();
        $patientModel = new \App\Models\patientModel();
        $activityModel = new \App\Models\userActivityModel();
        $userModel = new \App\Models\userModel();

        $therapist = $therapistModel->where('userId', $userId)->first();

        if (!$therapist) {
            return redirect()->to('/login')->with('error', 'Therapist not found.');
        }

        $today = date('Y-m-d');

        // Count today's appointments
        $todayAppointments = $appointmentModel
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->where('appointment.therapistId', $therapist['therapistId'])
            ->where('appointment.status', 'Approved')
            ->where('slot.date', $today)
            ->countAllResults();

        // Get upcoming appointment details
        $upcomingAppointments = $appointmentModel
            ->select('appointment.*, user.name as patient_name, slot.date, slot.startTime as appointment_time')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user', 'user.userId = patient.userId')
            ->where('appointment.therapistId', $therapist['therapistId'])
            ->where('slot.date >', $today)
            ->orderBy('slot.date', 'ASC')
            ->orderBy('slot.startTime', 'ASC')
            ->findAll(5);

        // Count total patients assigned to this therapist
        $totalPatients = $appointmentModel
            ->where('therapistId', $therapist['therapistId'])
            ->distinct()
            ->select('patientId')
            ->countAllResults();

        // Recent activity log (limit 5)
        $activities = $activityModel
            ->where('userId', $userId)
            ->orderBy('create_at', 'DESC')
            ->findAll(5);


        $recentActivities = array_map(function ($activity) {
            $message = strtolower($activity['activity']); // normalize

            $colorClass = 'tw-bg-gray-100';
            $icon = 'fas fa-info-circle tw-text-gray-500';

            if (str_contains($message, 'updated')) {
                $colorClass = 'tw-bg-yellow-100';
                $icon = 'fas fa-pen tw-text-yellow-600';
            } elseif (str_contains($message, 'cancelled')) {
                $colorClass = 'tw-bg-red-100';
                $icon = 'fas fa-times-circle tw-text-red-600';
            } elseif (str_contains($message, 'booked')) {
                $colorClass = 'tw-bg-green-100';
                $icon = 'fas fa-check-circle tw-text-green-600';
            } elseif (str_contains($message, 'remove') || str_contains($message, 'deleted')) {
                $colorClass = 'tw-bg-red-100';
                $icon = 'fas fa-trash-alt tw-text-red-600';
            }

            return [
                'message' => $activity['activity'],
                'time' => timeAgo($activity['create_at']),
                'color' => $colorClass,
                'icon' => $icon,
            ];
        }, $activities);


        $user = $userModel->find($userId);
        $weeklyHours = $slotModel->getWeeklySessionHoursByTherapist($therapist['therapistId']);


        return view('pages/therapistDashboard', [
            'therapist' => $therapist,
            'today_appointments' => $todayAppointments,
            'upcoming_appointments' => $upcomingAppointments,
            'total_patients' => $totalPatients,
            'recent_activities' => $recentActivities,
            'weekly_hours' => $weeklyHours,
            'user' => $user,
        ]);
    }


    public function addPatientRecord()
    {
        $session = session();
        $userId = $session->get('userId');
        if (!$userId || $session->get('role') !== 'therapist') {
            return redirect()->to('/login')->with('error', 'You must be logged in as a therapist.');
        }

        $appointmentModel = new \App\Models\AppointmentModel();
        $appointments = $appointmentModel->getAppointmentsByTherapist($userId);

        return view('pages/addPatientRecord', [
            'appointments' => $appointments,
        ]);
    }
}
