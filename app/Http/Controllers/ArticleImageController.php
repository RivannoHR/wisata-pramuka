<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageNoAltTextRequest;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleImageController extends Controller
{
    public function delete(String $article, ArticleImage $articleImage)
    {
        $order = $articleImage->sort_order;
        Storage::disk('public')->delete($articleImage->image_path);
        $articleImage->delete();
        ArticleImage::where('article_id', $article)
            ->where('sort_order', '>', $order)
            ->decrement('sort_order');
        return redirect()->back();
    }
    public function create(ImageNoAltTextRequest $request, Article $article)
    {
        $imagePath = $request->file('product_image')->store('articles/' . $article->id, 'public');
        $maxSortOrder = $article->images()->max('sort_order');
        $newSortOrder = $maxSortOrder !== null ? $maxSortOrder + 1 : 1;

        $newImage = new ArticleImage();


        $newImage->article_id = $article->id;
        $newImage->image_path = $imagePath;
        $newImage->sort_order = $newSortOrder;
        $newImage->save();
        return redirect()->back();
    }
    public function apply(ImageNoAltTextRequest $request, String $accomodation, ArticleImage $articleImage)
    {
        Storage::disk('public')->delete($articleImage->image_path);
        $articleImage->image_path = $request->file('product_image')->store('articles/' . $accomodation, 'public');
        $articleImage->save();
        return redirect()->back();
    }
}
