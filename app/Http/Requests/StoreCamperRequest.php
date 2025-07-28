<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCamperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // Only authenticated users can create campers
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'first_registration' => ['required', 'date'],
            'mileage' => ['required', 'integer', 'min:0'],
            'power' => ['required', 'integer', 'min:1'],
            'color' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'in:neu,gebraucht,unfallfahrzeug'],
            'camper_type' => ['required', 'string', 'max:255'],
            'berths' => ['required', 'integer', 'min:1'],
            'total_length' => ['required', 'numeric', 'min:0'],
            'total_width' => ['required', 'numeric', 'min:0'],
            'total_height' => ['required', 'numeric', 'min:0'],
            'gross_vehicle_weight' => ['required', 'integer', 'min:1'],
            'fuel_type' => ['required', 'string', 'max:255'],
            'transmission' => ['required', 'string', 'max:255'],
            'emission_class' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // 'seller_name' => ['nullable', 'string', 'max:255'],
            // 'seller_phone' => ['nullable', 'string', 'max:255'],
            // 'seller_email' => ['nullable', 'email', 'max:255'],
            'images' => ['nullable', 'array', 'max:10'], // Max 10 images
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Each image must be valid
        ];
    }
}