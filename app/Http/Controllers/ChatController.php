<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chatbot\ChatMessageRequest;
use App\Http\Requests\Chatbot\SaveLeadRequest;
use App\Http\Requests\Chatbot\SearchDestinationRequest;
use App\Models\ChatbotLead;
use App\Models\Destination;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(ChatMessageRequest $request): JsonResponse
    {
        $response = Http::post(
            config('chatbot.service_url'),
            [
                'message' => $request->validated('message'),
            ]
        );

        return response()->json(
            $response->json()
        );
    }


    public function saveLead(SaveLeadRequest $request): JsonResponse
    {
        $lead = ChatbotLead::create($request->validated());

        return response()->json([
            'success' => true,
            'id' => $lead->id,
        ]);
    }

    public function destinations(string $style): JsonResponse
    {
        $destinations = Destination::query()
            ->whereJsonContains('travel_styles', strtolower($style))
            ->pluck('name');

        return response()->json($destinations);
    }

    public function travelStyles(): JsonResponse
    {
        $styles = Destination::query()
            ->get(['travel_styles'])
            ->pluck('travel_styles')
            ->flatten()
            ->unique()
            ->values()
            ->push('Corporate Tour');

        return response()->json($styles);
    }

    public function themes(): JsonResponse
    {
        return response()->json(config('chatbot.themes'));
    }

    public function searchDestinations(SearchDestinationRequest $request): JsonResponse
    {
        $query = $request->queryText();

        $destinations = Destination::query()
            ->where('name', 'like', '%' . addcslashes($query, '%_\\') . '%')
            ->limit(8)
            ->pluck('name');

        return response()->json($destinations);
    }
}
