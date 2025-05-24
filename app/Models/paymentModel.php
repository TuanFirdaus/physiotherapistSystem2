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

    // Toyyibpay bill creation
    public function createBill($data)
    {
        $url = 'https://toyyibpay.com/index.php/api/createBill';

        try {
            $response = \Config\Services::curlrequest()->post($url, [
                'form_params' => $data,
            ]);

            $body = $response->getBody();
            log_message('error', 'Toyyibpay RAW Response: ' . $body); // <--- Add this
            log_message('error', 'Sending to Toyyibpay: ' . json_encode($data));


            $result = json_decode($body, true);
            dd($result);
            if (isset($result[0]['BillCode'])) {
                return $result[0]['BillCode'];
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'Toyyibpay API Exception: ' . $e->getMessage());
            return false;
        }
    }
}
