<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'title');
        $sortOrder = $request->get('order', 'asc');


        $query->orderBy($sortBy, $sortOrder);

        // Get page number for infinite scroll
        $page = $request->get('page', 1);
        $perPage = 20;

        $articles = $query->paginate($perPage, ['*'], 'page', $page);

        // If it's an AJAX request, return only the attraction cards
        if ($request->ajax()) {
            return response()->json([
                'html' => view('articles.partials.attraction-cards', compact('articles'))->render(),
                'hasMore' => $articles->hasMorePages(),
                'nextPage' => $articles->currentPage() + 1
            ]);
        }

        return view('articles.index', compact('articles'));
    }
    public function show(Request $request, Article $article)
    {
        // Load comments with user relationship, paginated
        $comments = $article->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('articles.show', compact('article', 'comments'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'article_image' => 'required|image|mimes:jpeg,png,gif,jpg,svg|max:6144'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $validatedData = $validator->validated();

        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category' => $validatedData['category']
        ]);

        $imagePath = $request->file('article_image')->store('articles/' . $article->id, 'public');

        ArticleImage::create([
            'article_id' => $article->id,
            'image_path' => $imagePath,
            'sort_order' => 1,
        ]);
        return redirect()->route('admin.articles');
    }
    public function apply(Request $request, Article $article)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $validatedData = $validator->validated();
        $article->update($validatedData);
        return redirect()->route('admin.articles');
    }
    public function delete(Request $request, Article $article)
    {
        Storage::disk('public')->delete('articles/' . $article->id);
        $article->delete();
        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        Storage::disk('public')->deleteDirectory('articles');
        Article::truncate();
        Storage::disk('public')->makeDirectory('articles');
        return redirect()->back();
    }
}
