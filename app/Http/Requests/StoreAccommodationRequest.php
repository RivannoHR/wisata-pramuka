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
            'rating' => 'nullable|numeric|min:0|max:5',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',

            // Initial image data
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_text' => 'required|string|max:255',

            // Initial room type data
            'room_name' => 'required|string|max:255',
            'room_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'room_price' => 'required|numeric|min:0',
        ];
    }

    // Custom messages to combine errors
    public function messages(): array
    {
        return [
            'product_image.required' => 'Accommodation must have an initial image.',
            'alt_text.required' => 'Accommodation must have an initial image.',

            'room_name.required' => 'Accommodation must have an initial room type.',
            'room_image.required' => 'Accommodation must have an initial room type.',
            'room_price.required' => 'Accommodation must have an initial room type.',
            'room_price.min' => 'Room price cannot be negative.',
        ];
    }
}
