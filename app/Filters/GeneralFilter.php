<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class GeneralFilter
{
    public static function product(Builder $query, Request $request)
    {
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Price filtering
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Filter by stock availability
        if ($request->has('stock_filter')) {
            switch ($request->stock_filter) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '=', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
            }
        }

        // Sorting
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'stock_asc':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public static function accommodation(Builder $query, Request $request)
    {
        if ($request->filled('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('accommodations.name', 'like', '%' . $search . '%')
                    ->orWhere('accommodations.location', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        if ($sortBy === 'rating') {
            $query->withAvg('ratings', 'rating')
                  ->orderBy('ratings_avg_rating', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        return $query;
    }
    public static function touristAttraction(Builder $query, Request $request)
    {
        if ($request->filled('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('tourist_attractions.name', 'like', '%' . $search . '%')
                    ->orWhere('tourist_attractions.location', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        if ($sortBy === 'rating') {
            $query->withAvg('ratings', 'rating')
                  ->orderBy('ratings_avg_rating', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        return $query;
    }
}
