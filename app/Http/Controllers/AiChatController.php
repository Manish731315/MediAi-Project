<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\SymptomSession;
use App\Services\AiDoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiChatController extends Controller
{
    protected AiDoctorService $aiService;

    public function __construct(AiDoctorService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function process(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userInput = $request->input('message');
        
        // 1. Get the structured AI response
        $aiResponse = $this->aiService->analyzeSymptoms($userInput);
        
        // 2. Log the conversation
        SymptomSession::create([
            'user_id' => Auth::id(),
            'symptoms_input' => $userInput,
            'ai_response' => json_encode($aiResponse), // Store the full JSON response
        ]);

        // 3. Find matching products in our DB
        // Cross-reference AI recommendations with our database to get product IDs
        $matchedProducts = [];
        if (isset($aiResponse['recommendations'])) {
            foreach ($aiResponse['recommendations'] as $rec) {
                // Use a flexible search to match AI name with DB name
                $medicine = Medicine::where('name', 'LIKE', '%' . $rec['medicine_name'] . '%')
                    ->where('prescription_required', false)
                    ->where('stock', '>', 0)
                    ->first();

                if ($medicine) {
                    $matchedProducts[] = [
                        'id' => $medicine->id,
                        'name' => $medicine->name,
                        'price' => $medicine->price,
                        'image' => $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/100',
                    ];
                }
            }
        }

        // 4. Add our DB-matched products to the response for the frontend
        $aiResponse['matched_products'] = $matchedProducts;
        
        return response()->json($aiResponse);
    }
}