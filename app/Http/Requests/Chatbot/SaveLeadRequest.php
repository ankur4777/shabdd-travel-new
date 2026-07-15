<?php

namespace App\Http\Requests\Chatbot;

use Illuminate\Foundation\Http\FormRequest;

class SaveLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_type' => ['nullable', 'string', 'max:255'],
            'help_type' => ['nullable', 'string', 'max:255'],
            'destination' => ['nullable', 'string', 'max:255'],
            'travel_date' => ['nullable', 'string', 'max:255'],
            'travel_month' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'adults' => ['nullable', 'string', 'max:255'],
            'children' => ['nullable', 'string', 'max:255'],
            'hotel_category' => ['nullable', 'string', 'max:255'],
            'flight_required' => ['nullable', 'string', 'max:255'],
            'departure_city' => ['nullable', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:255'],
            'package_need' => ['nullable', 'string', 'max:255'],
            'package_type' => ['nullable', 'string', 'max:255'],
            'whatsapp_updates' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'email', 'max:255'],
            'conversation' => ['nullable', 'array'],
            'conversation.*.sender' => ['required_with:conversation', 'in:user,bot'],
            'conversation.*.message' => ['required_with:conversation', 'string', 'max:4000'],
        ];
    }
}
