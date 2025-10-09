<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteStatistic;

class AboutController extends Controller
{
    public function index()
    {
        // Track visit
        SiteStatistic::incrementVisits();
        
        // Get formatted visits for display
        $visits = SiteStatistic::getTotalVisits();
        $formattedVisits = number_format($visits);
        
        return view('about.index', compact('formattedVisits'));
    }
}
