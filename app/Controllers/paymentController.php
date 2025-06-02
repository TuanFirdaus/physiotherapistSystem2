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
        $paymentModel = new \App\Models\paymentModel();
        $secretKey = env('TOYYIBPAY_SECRET_KEY');

        // Convert to cents (Toyyibpay expects integer)
        $amountInCents = (int) round(floatval($treatmentAmount) * 100);

        $billData = [
            'userSecretKey' => $secretKey,
            'categoryCode'  => 'v0hak85v',
            'billName'      => $treatmentName . 'Session',
            'billDescription' => 'Payment for ' . $treatmentName . ' treatment under patient name ' . $patientName,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount'    => $amountInCents, // in cents
            'billReturnUrl' => "https://0257-2001-e68-5472-8f87-9529-4949-f96a-665b.ngrok-free.app/payment/success",
            'billCallbackUrl' => "https://0257-2001-e68-5472-8f87-9529-4949-f96a-665b.ngrok-free.app/payment/callback",
            'billExternalReferenceNo' => 'REF-' . $appointmentId,
            'billTo'        => $this->request->getPost('name'),
            'billEmail'     => $this->request->getPost('email'),
            'billPhone'     => $this->request->getPost('phone'),
            'appointmentId' => $appointmentId,
        ];
        // dd($billData); // Debugging line to check the data being sent
        $billCode = $paymentModel->createBill($billData);

        // dd($billData, $secretKey, $billCode); // Debugging line to check the data being sent
        // dd(env('TOYYIBPAY_SECRET_KEY'));

        if ($billCode) {
            // $paymentModel = new \App\Models\PaymentModel();
            // Update the payment record with the generated billCode
            $payment = $paymentModel->where('appointmentId', $appointmentId)->first();
            // dd($payment); // Debugging line to check the payment data
            if ($payment) {
                $paymentModel->update($payment['paymentId'], [ // Use paymentId, not appointmentId
                    'billCode' => $billCode,
                    'paymentStatus' => 'Pending',
                ]);
            } else {
                log_message('error', 'No payment record found for appointmentId: ' . $appointmentId);
            }

            return redirect()->to("https://dev.toyyibpay.com/{$billCode}");
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create payment bill.');
        }
    }

    public function success()
    {
        $billCode = $this->request->getGet('billcode') ?? $this->request->getPost('billcode');
        // dd($billCode); // Debugging line to check the billCode
        $paymentModel = new \App\Models\PaymentModel();

        $patientId = session()->get('userId');

        // Fetch payment info from DB using billCode
        $payment = $paymentModel->where('billCode', $billCode)->first();
        // dd($payment); // Debugging line to check the payment data
        if (!$payment) {
            log_message('error', "No payment found for billCode: " . $billCode);
        }
        // dd($payment); // Debugging line to check the payment data
        // Optionally, fetch latest transaction info from Toyyibpay API
        $transaction = null;
        try {
            $apiUrl = 'https://dev.toyyibpay.com/index.php/api/getBillTransactions';
            $client = \Config\Services::curlrequest();
            $response = $client->post($apiUrl, [
                'form_params' => ['billCode' => $billCode]
            ]);


            $transactions = json_decode($response->getBody(), true);
            if (is_array($transactions) && count($transactions) > 0) {
                $transaction = $transactions[0];
            }
        } catch (\Exception $e) {
            log_message('error', 'Toyyibpay Success Exception: ' . $e->getMessage());
        }

        // Optionally, fetch appointment info if needed
        $appointment = null;
        if ($payment && isset($payment['appointmentId'])) {
            $appointmentModel = new \App\Models\AppointmentModel();
            $appointment = $appointmentModel->getAppointmentDetailsById($payment['appointmentId']);
        }

        $data = [
            'name'           => $appointment['patientName']    ?? 'N/A',
            'email'          => $appointment['patientEmail']   ?? 'N/A',
            'phone'          => $appointment['patientPhoneNum'] ?? 'N/A',
            'appointmentId'  => $payment['appointmentId']      ?? 'N/A',
            'treatmentName'  => $appointment['treatmentName']  ?? 'N/A',
            'treatmentPrice' => $appointment['treatmentPrice'] ?? 'N/A',
            'billCode' => $payment['billCode'] ?? $billCode,
            // Use Toyyibpay transaction data if available, else fallback to DB
            'billPaymentDate' => $transaction['billPaymentDate'] ?? $payment['billPaymentDate'] ?? null,
            'billPaymentAmount' => $transaction['billpaymentAmount'] ?? $payment['billPaymentAmount'] ?? null,
            'billPaymentInvoiceNo' => $transaction['billpaymentInvoiceNo'] ?? $payment['billPaymentInvoiceNo'] ?? null,
            'settlementReferenceNo' => $transaction['SettlementReferenceNo'] ?? $payment['settlementReferenceNo'] ?? null,
            'status' => $transaction['billpaymentStatus'] ?? $payment['paymentStatus'] ?? null,
            'date' => $appointment['date'] ?? null,
        ];
        // dd($data); // Debugging line to check the data being passed to the view

        return view('pages/paymentSuccess', $data);
    }

    public function callback()
    {
        log_message('info', 'ToyyibPay CALLBACK TEST REACHED');
        //kena baiki lagi method ni sbb tk dpt update payment table dgn appointment status
        log_message('info', 'ToyyibPay CALLBACK triggered. Raw POST: ' . json_encode($this->request->getPost()));

        $billcode = $this->request->getPost('billcode') ?? $this->request->getGet('billcode');
        log_message('info', 'Received callback for billcode: ' . $billcode);

        // dd($billcode); // Debugging line to check the billCode
        if (!$billcode) {
            return $this->response->setJSON(['error' => 'Billcode is missing or invalid.']);
        }



        try {
            // Call Toyyibpay API to get bill transactions
            $apiUrl = 'https://dev.toyyibpay.com/index.php/api/getBillTransactions';
            $client = \Config\Services::curlrequest();
            $response = $client->post($apiUrl, [
                'form_params' => ['billCode' => $billcode]
            ]);
            // dd($response);
            $responseBody = $response->getBody();

            log_message('info', 'ToyyibPay API response: ' . $responseBody);

            $transactions = json_decode($responseBody, true);

            if (is_array($transactions) && count($transactions) > 0) {
                $transaction = $transactions[0];
                $billStatus = $transaction['billpaymentStatus'] ?? null;

                if ($billStatus === '1') { // Payment successful
                    // Update payment status in your DB
                    $paymentModel = new \App\Models\PaymentModel();
                    $payment = $paymentModel->where('billCode', $billcode)->first();
                    // dd($payment);


                    if ($payment) {
                        // Update payment table
                        $paymentModel->update($payment['paymentId'], [
                            'paymentStatus' => 'Approved',
                            'paymentMethod' => 'Toyyibpay',
                            'billPaymentDate' => $transaction['billPaymentDate'] ?? null,
                            'payment_amount' => $transaction['billpaymentAmount'] ?? null,
                            'billCode' => $billcode,
                            'billPaymentInvoiceNo'    => $transaction['billpaymentInvoiceNo'] ?? null,
                            'settlementReferenceNo'   => $transaction['SettlementReferenceNo'] ?? null,

                        ]);

                        // Update appointment table
                        if (isset($payment['appointmentId'])) {
                            $appointmentModel = new \App\Models\AppointmentModel();
                            $appointmentModel->update($payment['appointmentId'], [
                                'status' => 'Approved'
                            ]);
                        }
                    }

                    return $this->response->setJSON(['status' => 'success', 'message' => 'Payment and appointment approved.']);
                } else {
                    // Payment failed, delete or update records as needed
                    $paymentModel = new \App\Models\PaymentModel();
                    $payment = $paymentModel->where('billCode', $billcode)->first();
                    if ($payment && isset($payment['paymentId'])) {
                        $paymentModel->delete($payment['paymentId']);
                    }

                    return $this->response->setJSON(['status' => 'failed', 'message' => 'Payment failed.']);
                }
            } else {
                return $this->response->setJSON(['error' => 'No transaction found.']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Toyyibpay Callback Exception: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'An error occurred while processing the payment: ' . $e->getMessage()]);
        }
    }
}
