<?php

namespace App\Controllers;

use App\Models\treatmentPackage;
use CodeIgniter\RESTful\ResourceController;

class aiController extends ResourceController
{
    public function getSuggestion()
    {
        $input = $this->request->getJSON(true);
        $bodyPart = $input['bodyPart'];
        $description = $input['description'];

        if (empty($bodyPart) || empty($description)) {
            return $this->fail('Missing input', 400);
        }

        $treatments = [
            "Physiotherapy",
            "Body Adjustment",
            "Sports Massage"
        ];

        $prompt = "A patient complains of pain in the $bodyPart. Description: $description.
        From this list of treatments: " . implode(', ', $treatments) . ",
        choose the most medically suitable one for the given symptoms. Only choose one.
        Respond exactly in this format:

        Treatment: [Name]
        Reason: [Brief reason for the choice]";

        log_message('info', 'AI API Prompt: ' . $prompt);

        $apiKey = getenv('GEMINI_API_KEY') ?? env('GEMINI_API_KEY');

        $ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey);
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
        log_message('info', 'AI API Raw Response: ' . $response);
        curl_close($ch);

        $result = json_decode($response, true);
        log_message('info', 'AI API Decoded Result: ' . json_encode($result));

        $suggestionRaw = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
        log_message('info', 'AI Suggestion Raw: ' . $suggestionRaw);

        preg_match('/Treatment:\s*(.+)/i', $suggestionRaw, $matchName);
        preg_match('/Reason:\s*(.+)/i', $suggestionRaw, $matchReason);

        $suggestedName = trim($matchName[1] ?? '');
        $suggestedReason = trim($matchReason[1] ?? '');


        if (isset($suggestionRaw)) {
            log_message('info', 'AI Suggestion Raw: ' . $suggestionRaw);
        } else {
            log_message('info', 'AI Suggestion Raw is not set');
        }

        foreach ($treatments as $t) {
            if (stripos($suggestionRaw, $t) !== false) {
                $suggestedName = $t;
                break;
            }
        }

        if (empty($suggestedName)) {
            return $this->respond(['treatment' => 'Unknown treatment']);
        }

        $model = new treatmentPackage();
        $treatment = $model->like('name', $suggestedName, 'both')->first();

        log_message('info', 'AI Suggestion treatment: ' . json_encode($treatment));




        if ($treatment) {
            return $this->respond([
                'treatmentName' => $treatment['name'],
                'treatmentId' => $treatment['treatmentId'],
                'treatmentPrice' => $treatment['price'],
                'treatmentReason' => $suggestedReason,
            ]);
        } else {
            return $this->respond(['treatment' => 'Unknown treatment']);
        }
    }
}
