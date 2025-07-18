<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'brand_id' => 'required|exists:brands,id',
        'car_model_id' => 'nullable|exists:car_models,id',
        'price' => 'nullable|numeric|min:0',
        'images.*' => 'nullable|image|max:5120', // max 5MB ανά εικόνα
    ];
}

}
