<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Article $article)
    {
        // Validate that user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to login to post a comment.');
        }

        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000|min:3',
        ], [
            'content.required' => 'Comment content is required.',
            'content.max' => 'Comment must not exceed 1000 characters.',
            'content.min' => 'Comment must be at least 3 characters long.',
        ]);

        // Create the comment
        ArticleComment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Your comment has been posted successfully!');
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, ArticleComment $comment)
    {
        // Validate that the comment belongs to the authenticated user
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this comment.');
        }

        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000|min:3',
        ]);

        // Update the comment
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Your comment has been updated successfully!');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(ArticleComment $comment)
    {
        // Check if user can delete (either comment owner or admin)
        if ($comment->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access to this comment.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment has been deleted successfully!');
    }

    /**
     * Get comments for an article (AJAX endpoint)
     */
    public function getComments(Article $article)
    {
        $comments = $article->comments()
            ->with('user')
            ->recent()
            ->paginate(10);

        return response()->json([
            'comments' => $comments->items(),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
            ]
        ]);
    }
}
