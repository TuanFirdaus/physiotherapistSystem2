<?php

namespace App\Models;

use CodeIgniter\Model;

class paymentModel extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'paymentId';
    protected $allowedFields = ['appointmentId', 'patientId', 'treatmentId', 'payment_amount', 'status'];
    protected $returnType = 'array';

    public function getPaymentDetails($appointmentId)
    {
        return $this->where('appointmentId', $appointmentId)->first();
    }

    public function getTotalPendingPayments()
    {
        return $this->db->table('payment')
            ->select('COUNT(*) as totalPendingPayments')
            ->where('status', 'pending')
            ->countAllResults();
    }

    public function getAllPayments()
    {
        return $this->findAll();
    }

    public function addPayment($data)
    {
        return $this->insert($data);
    }

    public function updatePayment($paymentId, $data)
    {
        return $this->update($paymentId, $data);
    }

    public function deletePayment($paymentId)
    {
        return $this->delete($paymentId);
    }
}
