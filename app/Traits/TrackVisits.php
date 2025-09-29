<?php

namespace App\Traits;

use App\Models\SiteStatistic;

trait TrackVisits
{
    /**
     * Track visits for an item
     */
    protected function trackVisit($itemType, $itemId, $itemName = null)
    {
        $today = now()->format('Y-m-d');
        
        // Find or create today's statistic record for this item
        $statistic = SiteStatistic::firstOrCreate(
            [
                'item_type' => $itemType,
                'item_id' => $itemId,
                'date' => $today
            ],
            [
                'item_name' => $itemName,
                'visits' => 0
            ]
        );
        
        // Increment the visit count
        $statistic->increment('visits');
        
        return $statistic;
    }
    
    /**
     * Get visit counts for items
     */
    protected function getVisitCounts($itemType, $limit = 5)
    {
        return SiteStatistic::where('item_type', $itemType)
            ->selectRaw('item_id, item_name, SUM(visits) as total_visits')
            ->groupBy('item_id', 'item_name')
            ->orderByDesc('total_visits')
            ->limit($limit)
            ->get();
    }
}
