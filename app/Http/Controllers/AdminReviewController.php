<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\TouristAttraction;
use App\Models\Article;
use App\Models\Review;
use App\Models\Rating;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReviewController extends Controller
{
    /**
     * Display accommodation reviews
     */
    public function accommodationReviews($accommodationId)
    {
        $accommodation = Accommodation::findOrFail($accommodationId);
        
        // Get reviews from completed bookings
        $reviews = Review::whereHas('booking', function($query) use ($accommodationId) {
            $query->where('accommodation_id', $accommodationId)
                  ->where('status', 'completed');
        })
        ->with(['user', 'booking'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('admin.accommodations.reviews.index', compact('accommodation', 'reviews'));
    }

    /**
     * Display tourist attraction reviews
     */
    public function touristAttractionReviews($attractionId)
    {
        $attraction = TouristAttraction::findOrFail($attractionId);
        
        // Get reviews (ratings with comments)
        $reviews = Rating::where('ratable_type', TouristAttraction::class)
            ->where('ratable_id', $attractionId)
            ->whereNotNull('comment')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.tourist-attractions.reviews.index', compact('attraction', 'reviews'));
    }

    /**
     * Delete accommodation review
     */
    public function deleteAccommodationReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $accommodationId = $review->booking->accommodation_id;
        
        $review->delete();

        return redirect()->route('admin.accommodations.reviews', $accommodationId)
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Delete tourist attraction review
     */
    public function deleteTouristAttractionReview($reviewId)
    {
        $review = Rating::findOrFail($reviewId);
        $attractionId = $review->ratable_id;
        
        $review->delete();

        return redirect()->route('admin.tourist-attractions.reviews', $attractionId)
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Bulk delete accommodation reviews
     */
    public function bulkDeleteAccommodationReviews(Request $request, $accommodationId)
    {
        $reviewIds = $request->input('review_ids', []);
        
        if (!empty($reviewIds)) {
            Review::whereIn('id', $reviewIds)->delete();
            
            return redirect()->route('admin.accommodations.reviews', $accommodationId)
                ->with('success', count($reviewIds) . ' reviews deleted successfully.');
        }

        return redirect()->route('admin.accommodations.reviews', $accommodationId)
            ->with('error', 'No reviews selected for deletion.');
    }

    /**
     * Bulk delete tourist attraction reviews
     */
    public function bulkDeleteTouristAttractionReviews(Request $request, $attractionId)
    {
        $reviewIds = $request->input('review_ids', []);
        
        if (!empty($reviewIds)) {
            Rating::whereIn('id', $reviewIds)->delete();
            
            return redirect()->route('admin.tourist-attractions.reviews', $attractionId)
                ->with('success', count($reviewIds) . ' reviews deleted successfully.');
        }

        return redirect()->route('admin.tourist-attractions.reviews', $attractionId)
            ->with('error', 'No reviews selected for deletion.');
    }

    /**
     * Display article comments for management
     */
    public function articleComments($articleId)
    {
        $article = Article::findOrFail($articleId);
        
        $comments = ArticleComment::where('article_id', $articleId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.articles.comments.index', compact('article', 'comments'));
    }
    
    /**
     * Delete a specific article comment
     */
    public function deleteArticleComment($commentId)
    {
        $comment = ArticleComment::findOrFail($commentId);
        $articleId = $comment->article_id;
        $comment->delete();
        
        return redirect()->route('admin.articles.comments', $articleId)
            ->with('success', 'Comment deleted successfully.');
    }
    
    /**
     * Bulk delete article comments
     */
    public function bulkDeleteArticleComments(Request $request, $articleId)
    {
        $commentIds = $request->input('comment_ids', []);
        
        if (!empty($commentIds)) {
            ArticleComment::whereIn('id', $commentIds)
                ->where('article_id', $articleId)
                ->delete();
            
            return redirect()->route('admin.articles.comments', $articleId)
                ->with('success', count($commentIds) . ' comments deleted successfully.');
        }

        return redirect()->route('admin.articles.comments', $articleId)
            ->with('error', 'No comments selected for deletion.');
    }
}
