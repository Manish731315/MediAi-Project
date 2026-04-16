<?php

namespace App\Services;

use App\Models\Medicine;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class AiDoctorService
{
    protected ?string $geminiKey;
    protected string $geminiUrlBase = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        // Simplified to only load the Gemini key
        $this->geminiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');
    }

    /**
     * Public entry: analyze symptoms and return structured array.
     */
    public function analyzeSymptoms(string $userInput): array
    {
        $otcMedicines = $this->getAvailableOtcMedicines();
        $systemPrompt = $this->buildSystemPrompt($otcMedicines);

        // Always calls Gemini
        return $this->callGemini($systemPrompt, $userInput);
    }

    /**
     * Call Gemini (Google Generative Language) API
     */
    protected function callGemini(string $systemPrompt, string $userInput): array
    {
        if (empty($this->geminiKey)) {
            Log::error('Gemini key missing');
            return $this->errorResponse('AI misconfigured: Gemini key missing.');
        }
        
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash');
        $model = str_replace('models/', '', $model);
        $url = "{$this->geminiUrlBase}/{$model}:generateContent";
        
        try {
            $payload = [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $userInput]]],
                ],
                'generationConfig' => [
                    'temperature' => floatval(env('AI_TEMPERATURE', 0.3)),
                    'maxOutputTokens' => intval(env('AI_MAX_TOKENS', 2048)),
                    'responseMimeType' => 'application/json',
                ],
            ];
            
            $response = Http::timeout(intval(env('AI_TIMEOUT', 90)))
                ->post("{$url}?key={$this->geminiKey}", $payload);
            
            Log::debug('Gemini call', [
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 2000)
            ]);
            
            if ($response->failed()) {
                $err = $response->json();
                $errMsg = $err['error']['message'] ?? json_encode($err);
                return $this->errorResponse('Gemini service unavailable. HTTP status: ' . $response->status() . '. ' . $errMsg);
            }
            
            $json = $response->json();
            
            $text = null;
            if (!empty($json['candidates'][0]['content']['parts'][0]['text'])) {
                $text = $json['candidates'][0]['content']['parts'][0]['text'];
            }
            
            if (empty($text)) {
                return $this->errorResponse('Invalid response from Gemini service (no text). Full body: ' . substr($response->body(), 0, 1500));
            }

            // Clean the JSON response (removes ```json ... ```)
            if (preg_match('/\{.*\}/s', $text, $matches)) {
                $text = $matches[0];
            } else {
                $text = trim($text);
                $text = str_replace("```json", "", $text);
                $text = str_replace("```", "", $text);
            }
            
            $decoded = json_decode($text, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->errorResponse('Failed to parse Gemini response JSON. Raw: ' . substr($text, 0, 1000));
            }
            
            return $decoded;
            
        } catch (\Throwable $e) {
            Log::error('callGemini exception', ['msg' => $e->getMessage()]);
            return $this->errorResponse('Error connecting to Gemini: ' . $e->getMessage());
        }
    }
    
    /**
     * Fetch OTC medicines
     */
    private function getAvailableOtcMedicines(): Collection
    {
        return Medicine::where('prescription_required', false)
            ->where('stock', '>', 0)
            ->get(['name', 'category_id', 'description']);
    }

    /**
     * Build system prompt
     */
    private function buildSystemPrompt(Collection $otcMedicines): string
    {
        if ($otcMedicines->isEmpty()) {
            $medicineList = "No OTC medicines are currently available.";
        } else {
            $medicineList = $otcMedicines->map(function ($med) {
                return "- {$med->name} (Category: {$med->category}, Desc: {$med->description})";
            })->implode("\n");
        }

        return <<<PROMPT
You are "MediAI Assistant", a virtual health assistant for an online pharmacy.
Your goal is to analyze user symptoms and suggest *only* suitable Over-The-Counter (OTC) medicines from our available stock.

**OUR AVAILABLE OTC STOCK:**
{$medicineList}

**YOUR INSTRUCTIONS:**
1.  **Analyze Symptoms:** Read the user's message to understand their symptoms.
2.  **Check Severity:**
    * If symptoms sound severe, dangerous, or life-threatening (e.g., "chest pain", "difficulty breathing", "severe bleeding"), DO NOT recommend medicine. Your primary response must be to advise them to see a real doctor immediately.
    * If symptoms are mild (e.g., "headache", "mild cough", "sore throat"), proceed.
3.  **Recommend Medicine (if mild):**
    * Cross-reference the symptoms with **OUR AVAILABLE OTC STOCK** provided above.
    * Recommend 1-2 suitable medicines *only from that list*.
    * If no medicine on our list is a good match, do not recommend anything. Instead, suggest consulting a pharmacist or doctor.
4.  **NEVER Recommend:**
    * Any prescription-only drug (e.g., antibiotics, strong painkillers, controlled substances).
    * Any medicine *not* on the provided stock list.
    * Specific medical diagnoses (e.g., "You have the flu"). Instead, say "This sounds like a common cold."
5.  **Format:** You MUST respond *only* with the raw JSON object, starting with { and ending with }. Do not include the \`\`\`json markdown fences or any other text.
6.  **Disclaimer:** ALWAYS include the medical disclaimer.

**JSON OUTPUT FORMAT:**
{
  "analysis": "Your conversational analysis of their symptoms.",
  "severity": "mild|moderate|severe",
  "recommendations": [
    {
      "medicine_name": "Name of the medicine FROM THE STOCK LIST",
      "reason": "Brief reason why this helps.",
      "type": "OTC"
    }
  ],
  "disclaimer": "This AI is not a medical professional. Please consult a doctor for an accurate diagnosis."
}
PROMPT;
    }

    /**
     * Uniform error response
     */
    private function errorResponse(string $message): array
    {
        return [
            'analysis' => $message,
            'severity' => 'error',
            'recommendations' => [],
            'disclaimer' => 'This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.'
        ];
    }
}