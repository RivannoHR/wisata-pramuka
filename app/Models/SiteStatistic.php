<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStatistic extends Model
{
    protected $fillable = ['key', 'value', 'date'];

    /**
     * Get total site visits
     */
    public static function getTotalVisits()
    {
        $stat = self::where('key', 'total_visits')->first();
        return $stat ? $stat->value : 0;
    }

    /**
     * Increment total visits
     */
    public static function incrementVisits()
    {
        $stat = self::where('key', 'total_visits')->first();
        
        if ($stat) {
            $stat->increment('value');
        } else {
            self::create([
                'key' => 'total_visits',
                'value' => 1
            ]);
        }
    }

    /**
     * Format visit count for display
     */
    public static function formatVisitCount($count = null)
    {
        $count = $count ?? self::getTotalVisits();
        
        if ($count >= 1000000) {
            return round($count / 1000000, 1) . 'M';
        } elseif ($count >= 1000) {
            return round($count / 1000, 1) . 'K';
        }
        
        return number_format($count);
    }
}
