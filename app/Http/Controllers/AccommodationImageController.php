<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImageRequest;
use App\Models\Accommodation;
use App\Models\AccommodationImage;
use Illuminate\Support\Facades\Storage;

class AccommodationImageController extends Controller
{
    public function toggleFeatured(String $accommodation, AccommodationImage $accommodationimage)
    {
        $accommodationimage->is_featured = !$accommodationimage->is_featured;
        $accommodationimage->save();
        return redirect()->back();
    }

    public function delete(String $accommodation, AccommodationImage $accommodationimage)
    {
        $order = $accommodationimage->sort_order;
        Storage::disk('public')->delete($accommodationimage->image_path);
        $accommodationimage->delete();
        AccommodationImage::where('accommodation_id', $accommodation)
            ->where('sort_order', '>', $order)
            ->decrement('sort_order');
        return redirect()->back();
    }
    public function create(CreateImageRequest $request, Accommodation $accommodation)
    {
        $imagePath = $request->file('product_image')->store('accommodations/' . $accommodation->id, 'public');
        $maxSortOrder = $accommodation->images()->max('sort_order');
        $newSortOrder = $maxSortOrder !== null ? $maxSortOrder + 1 : 1;

        $newImage = new AccommodationImage();


        $newImage->accommodation_id = $accommodation->id;
        $newImage->image_path = $imagePath;
        $newImage->sort_order = $newSortOrder;
        $newImage->alt_text = $request->alt_text;
        $newImage->save();
        return redirect()->back();
    }
    public function apply(CreateImageRequest $request, String $accomodation, AccommodationImage $accommodationimage)
    {
        Storage::disk('public')->delete($accommodationimage->image_path);
        $accommodationimage->image_path = $request->file('product_image')->store('accommodations/' . $accomodation, 'public');
        $accommodationimage->alt_text = $request->alt_text;
        $accommodationimage->save();
        return redirect()->back();
    }
}
