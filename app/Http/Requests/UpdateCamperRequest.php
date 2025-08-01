<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCamperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure the authenticated user owns the camper they are trying to update
        return Auth::check() && Auth::user()->id === $this->route('camper')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'camper_brand_id' => ['required', 'exists:camper_brands,id'],
            'camper_model_id' => ['nullable', 'exists:camper_models,id'],
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
            'images' => ['nullable', 'array', 'max:10'], // New images being uploaded
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'existing_images' => ['nullable', 'array'], // Array of IDs of existing images to keep
            'existing_images.*' => ['exists:camper_images,id'], // Ensure existing images actually exist
        ];
    }
}
