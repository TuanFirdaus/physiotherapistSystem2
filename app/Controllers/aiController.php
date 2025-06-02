<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class aiController extends Controller
{
    public function getSuggestion()
    {
        $input = $this->request->getJSON(true);
        $bodyPart = $input['bodyPart'] ?? '';
        $description = $input['description'] ?? '';

        $treatments = [
            "Physiotherapy",
            "Body Adjustment",
            "Sports Massage",
        ];

        if (empty($bodyPart) || empty($description)) {
            return $this->response->setJSON(['error' => 'Missing input'])->setStatusCode(400);
        }

        $prompt = "Patient reports pain in the $bodyPart. Description: $description. From this list: " . implode(', ', $treatments) . ", suggest the most suitable treatment. Return ONLY the name of the treatment.";

        $apiKey = getenv('GEMINI_API_KEY');

        $ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]),
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $suggestionRaw = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
        $suggestedName = '';

        foreach ($treatments as $t) {
            if (stripos($suggestionRaw, $t) !== false) {
                $suggestedName = $t;
                break;
            }
        }

        // ✅ If no match found
        if (empty($suggestedName)) {
            return $this->response->setJSON(['treatment' => 'Unknown treatment']);
        }

        // ✅ Load your treatment model
        $treatmentModel = new \App\Models\treatmentPackage();
        $treatment = $treatmentModel->like('name', $suggestedName, 'both')->first();

        if ($treatment) {
            log_message('debug', 'Gemini raw suggestion: ' . $suggestionRaw);
            log_message('debug', 'Matched treatment name: ' . $suggestedName);
            log_message('debug', print_r($treatment, true));
            return $this->response->setJSON([
                'treatment' => $treatment['name'],
                'treatmentId' => $treatment['treatmentId'],
                'treatmentPrice' => $treatment['price'],
            ]);
        } else {
            return $this->response->setJSON(['treatment' => 'Unknown treatment']);
        }
    }
}
