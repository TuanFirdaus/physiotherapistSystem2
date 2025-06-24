<?php

namespace App\Controllers;

use App\Models\treatmentModel;
use App\Models\treatmentRecords;
use App\Models\patientModel;
use App\Models\UserModel;

class treatmentController extends BaseController
{
    protected $treatmentModel;
    protected $patientModel;
    protected $userModel;
    protected $treatmentRecords;

    public function __construct()
    {
        $this->treatmentModel = new TreatmentModel();
        $this->patientModel = new patientModel();
        $this->userModel = new UserModel();
        $this->treatmentRecords = new treatmentRecords();
    }
    // try barus
    public function index()
    {
        $model = new treatmentRecords();
        $data['records'] = $model->getAllDetailedRecords();
        return view('pages/treatmentRecordsView', $data);
    }

    public function viewByPatient($patientId)
    {
        $model = new treatmentRecords();
        $data['records'] = $model->getRecordsByPatient($patientId);
        return view('pages/view_by_patient', $data);
    }
    //sampai sini
    public function showTreatmentRecords()
    {
        return view('pages/treatmentRecords', [
            'treatments' => $this->treatmentModel->getAllWithPatientDetails(), // Create this method to join treatment and patient tables
        ]);
    }

    // Show the add/edit form
    public function addTreatmentRecord()
    {
        $session = session();
        $userId = $session->get('userId');
        $patients = $this->patientModel->getAllWithUserInfo(); // Create this method to join patients and users
        $appointmentDetails = $this->patientModel->treatmentFormDetails($userId); // Get appointment details for the patient

        return view('pages/addTreatment', [
            'patients' => $patients,
            'appointmentDetails' => $appointmentDetails,
        ]);
    }

    // Save treatment record
    public function save()
    {
        $id = $this->request->getPost('record_id');

        // If creating new, generate recordId
        if (!$id) {
            $id = $this->generateNewRecordId(); // Use your custom function to generate e.g. REC001
        }

        $data = [
            'recordId'       => $id, // Must match your primary key
            'patientId'      => $this->request->getPost('patient_id'),
            'treatmentId'    => $this->request->getPost('treatment_id'),
            'appointmentId'  => $this->request->getPost('appointment_id'),
            'therapistId'    => $this->request->getPost('therapist_id'), // Hidden field
            'slotId'         => $this->request->getPost('slot_id'),      // Hidden field
            'pain_rate'       => $this->request->getPost('pain_rate'),
            'status'          => $this->request->getPost('status'),
            'treatmentNotes' => $this->request->getPost('treatment_notes'),
        ];

        if ($this->treatmentModel->find($id)) {
            $this->treatmentModel->update($id, $data);
        } else {
            $this->treatmentModel->insert($data);
        }

        return redirect()->to('/treatment')->with('success', 'Treatment record saved.');
    }


    // AJAX endpoint to get patient details
    public function getPatientDetails($id)
    {
        $patient = $this->patientModel->getPatientWithUser($id); // Implement this method in PatientModel
        $appointments = $this->patientModel->treatmentFormDetails($id);
        if ($patient) {
            // Check if the patient has previous treatment records
            $hasRecords = $this->treatmentModel
                ->where('patientId', $id)
                ->countAllResults() > 0;

            return $this->response->setJSON([
                'success' => true,
                'patient' => [
                    'name' => $patient['name'],
                ],
                'appointments' => $appointments,
                'hasTreatmentRecords' => $hasRecords,
            ]);
        }

        return $this->response->setJSON(['success' => false]);
    }

    private function generateNewRecordId()
    {
        $last = $this->treatmentModel
            ->select('recordId')
            ->orderBy('recordId', 'DESC')
            ->first(); // returns an associative array

        if ($last && isset($last['recordId']) && preg_match('/REC(\d+)/', $last['recordId'], $matches)) {
            $number = (int) $matches[1] + 1;
        } else {
            $number = 1;
        }

        return 'REC' . str_pad($number, 3, '0', STR_PAD_LEFT); // e.g., REC001
    }
}
