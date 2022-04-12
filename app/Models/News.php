<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Sources;

class News extends Model
{
    protected $table = 'news';

    static function getAvailable()
    {
        return self::get();
    }

    static function getFromSources($sources)
    {   

        $databaseSources = Sources::getAvailableIDs();      
        $availableSources = [];

        foreach ($databaseSources as $databaseSource) {
            if (in_array($databaseSource, $sources)) {
                $availableSources[] = $databaseSource;
            }
        }

        return self::whereDate('external_created_at', '>=', Carbon::now('Europe/Amsterdam')->subDays(count($availableSources) > 6 ? 2 : 7))
        ->whereIn('source_id', $availableSources)
        ->orderBy('external_created_at', 'desc')->get();
    }
}