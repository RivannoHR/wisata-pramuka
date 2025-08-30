<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoomTypeRequest;
use App\Models\Accommodation;
use App\Models\AccommodationRoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccommodationRoomTypeController extends Controller
{
    public function create(CreateRoomTypeRequest $request, Accommodation $accommodation)
    {
        $imagePath = $request->file('image')->store('accommodations/' . $accommodation->id . '/rooms', 'public');

        $accommodation->roomTypes()->create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'image_path' => $imagePath,
        ]);

        return redirect()->back();
    }
    public function delete(Accommodation $accommodation, AccommodationRoomType $accommodationroomtype)
    {
        Storage::disk('public')->delete($accommodationroomtype->image_path);
        $accommodationroomtype->delete();

        return redirect()->back();
    }
    public function apply(CreateRoomTypeRequest $request, Accommodation $accommodation, AccommodationRoomType $accommodationroomtype)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($accommodationroomtype->image_path);

            // Store the new image
            $data['image_path'] = $request->file('image')->store('accommodations/' . $accommodation->id . '/rooms', 'public');
        }

        $accommodationroomtype->update($data);

        return redirect()->back();
    }
}
