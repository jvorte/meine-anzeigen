<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ή auth()->check() αν θέλεις authenticated users μόνο
    }

 public function rules()
{
    return [
        'category_slug'   => 'required|string',
        'brand_id'        => 'nullable|exists:brands,id',
        'car_model_id'    => 'nullable|exists:car_models,id',
        'price_from'      => 'required|numeric',
        'mileage_from'    => 'nullable|numeric',
        'registration_to' => 'nullable|date',
        'vehicle_type'    => 'nullable|string',
        'condition'       => 'nullable|string',
        'warranty'        => 'nullable|string',
        'power_from'      => 'nullable|numeric',
        'fuel_type'       => 'required|string',
        'transmission'    => 'required|string',
        'drive'           => 'nullable|string',
        'color'           => 'nullable|string',
        'doors_from'      => 'nullable|integer',
        'seats_from'      => 'nullable|integer',
        'seller_type'     => 'required|string',
        'title'           => 'required|string|max:255',
        'description'     => 'required|string',
        'images.*'        => 'nullable|image|max:5120', // 5MB ανά εικόνα
    ];
}

}
