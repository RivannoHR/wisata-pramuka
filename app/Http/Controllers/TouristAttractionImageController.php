<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImageRequest;
use App\Models\TouristAttraction;
use App\Models\TouristAttractionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TouristAttractionImageController extends Controller
{
    public function toggleFeatured(String $touristAttraction, TouristAttractionImage $touristAttractionImage)
    {
        $touristAttractionImage->is_featured = !$touristAttractionImage->is_featured;
        $touristAttractionImage->save();
        return redirect()->back();
    }

    public function delete(String $touristAttraction, TouristAttractionImage $touristAttractionImage)
    {
        $order = $touristAttractionImage->sort_order;
        Storage::disk('public')->delete($touristAttractionImage->image_path);
        $touristAttractionImage->delete();
        TouristAttractionImage::where('tourist_attraction_id', $touristAttraction)
            ->where('sort_order', '>', $order)
            ->decrement('sort_order');
        return redirect()->back();
    }
    public function create(CreateImageRequest $request, TouristAttraction $touristAttraction)
    {
        $imagePath = $request->file('product_image')->store('attractions/' . $touristAttraction->id, 'public');
        $maxSortOrder = $touristAttraction->images()->max('sort_order');
        $newSortOrder = $maxSortOrder !== null ? $maxSortOrder + 1 : 1;

        $newImage = new TouristAttractionImage();


        $newImage->tourist_attraction_id = $touristAttraction->id;
        $newImage->image_path = $imagePath;
        $newImage->sort_order = $newSortOrder;
        $newImage->alt_text = $request->alt_text;
        $newImage->save();
        return redirect()->back();
    }
    public function apply(CreateImageRequest $request, String $accomodation, TouristAttractionImage $touristAttractionImage)
    {
        Storage::disk('public')->delete($touristAttractionImage->image_path);
        $touristAttractionImage->image_path = $request->file('product_image')->store('attractions/' . $accomodation, 'public');
        $touristAttractionImage->alt_text = $request->alt_text;
        $touristAttractionImage->save();
        return redirect()->back();
        
    }
}
