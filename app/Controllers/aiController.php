<?php

namespace App\Controllers;

use App\Libraries\GeminiService;

class Ai extends BaseController
{
    public function index()
    {
        return view('pain_form');
    }

    public function recommend()
    {
        $part = $this->request->getPost('body_part');
        $desc = $this->request->getPost('pain_description');

        $gemini = new GeminiService();

        $treatments = [
            "Physiotherapy",
            "Acupuncture",
            "Manual Therapy",
            "Sports Massage",
            "Chiropractic Care"
        ];

        $prompt = "A patient has pain in the $part. They describe it as: \"$desc\". " .
            "Based on the available treatments in our clinic (" . implode(', ', $treatments) . "), " .
            "suggest the most suitable treatment with a short explanation only.";

        $response = $gemini->generateText($prompt);
        $recommendation = $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No suggestion available.';

        return view('recommend_result', [
            'part' => $part,
            'description' => $desc,
            'recommendation' => $recommendation
        ]);
    }

    public function book()
    {
        $data = $this->request->getPost();
        // Save to DB or send to doctor/admin (you can extend this)
        return view('booking_success', ['data' => $data]);
    }
}
