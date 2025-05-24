<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use CodeIgniter\HTTP\ResponseInterface;

class paymentController extends BaseController
{
    public function getPayForm()
    {
        $data = [
            'appointmentId'   => $this->request->getVar('appointmentId'),
            'treatmentPrice'  => $this->request->getVar('treatmentPrice'),
            'name'            => $this->request->getVar('patientName'),
            'email'           => $this->request->getVar('patientEmail'),
            'phone'           => $this->request->getVar('patientPhoneNum'),
            'treatmentName'   => $this->request->getVar('treatmentName'),
            'date'            => $this->request->getVar('date'),
            'status'          => $this->request->getVar('status'),
        ];
        // dd($data);
        return view('pages/paymentForm', $data);
    }

    public function createBill()
    {
        $treatmentAmount = $this->request->getVar('treatmentPrice');
        $patientName = $this->request->getVar('patientName');
        $appointmentId = $this->request->getVar('appointmentId');
        $treatmentName = $this->request->getVar('treatmentName');
        $paymentModel = new \App\Models\PaymentModel();

        // Convert to cents (Toyyibpay expects integer)
        $amountInCents = (int) round(floatval($treatmentAmount) * 100);

        $billData = [
            'userSecretKey' => env('TOYYIBPAY_SECRET_KEY'),
            'categoryCode'  => 'v0hak85v',
            'billName'      => $treatmentName . 'Session',
            'billDescription' => 'Payment for ' . $treatmentName . ' treatment under patient name ' . $patientName,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount'    => $amountInCents, // in cents
            'billReturnUrl' => base_url('payment/success'),
            'billCallbackUrl' => base_url('payment/callback'),
            'billExternalReferenceNo' => 'REF-' . $appointmentId,
            'billTo'        => $this->request->getPost('name'),
            'billEmail'     => $this->request->getPost('email'),
            'billPhone'     => $this->request->getPost('phone'),
        ];

        $billCode = $paymentModel->createBill($billData);

        // dd($billCode);

        if ($billCode) {
            return redirect()->to("https://toyyibpay.com/{$billCode}");
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create payment bill.');
        }
    }

    public function success()
    {
        return view('payment_success');
    }

    public function callback()
    {
        $postData = $this->request->getPost();

        // Example log
        log_message('info', 'Payment callback received: ' . json_encode($postData));

        // Check if payment is successful
        if (isset($postData['billpaymentStatus']) && $postData['billpaymentStatus'] == '1') {
            // Get your appointment reference number (assume it's saved in billExternalReferenceNo)
            $referenceNo = $postData['billExternalReferenceNo'];

            // Extract appointmentId from reference number if you've formatted it like REF-123
            $appointmentId = str_replace('REF-', '', $referenceNo);

            // Update appointment status to 'paid'
            $appointmentModel = new \App\Models\AppointmentModel();
            $appointmentModel->update($appointmentId, ['status' => 'paid']);

            log_message('info', 'Payment successful for appointment ID: ' . $appointmentId);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
