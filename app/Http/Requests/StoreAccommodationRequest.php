<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccommodationRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (auth()->user()->isAdmin()) return true;
        return false;
    }

    public function rules(): array
    {
        return [
            // Accommodation core data
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:hotel,villa,guesthouse,resort',
            'location' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'facilities' => 'nullable|string',

            // Initial image data
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_text' => 'required|string|max:255',
        ];
    }

    // Custom messages to combine errors
    public function messages(): array
    {
        return [
            'product_image.required' => 'Accommodation must have an initial image.',
            'alt_text.required' => 'Accommodation must have an initial image.',
            'price.required' => 'Price per night is required.',
            'price.min' => 'Price cannot be negative.',
        ];
    }
}
