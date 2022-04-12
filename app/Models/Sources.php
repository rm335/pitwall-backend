<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sources extends Model
{
    protected $table = 'sources';

    static function getAvailable()
    {
        $national = self::select('id', 'name', 'icon_url', 'is_national')
        ->where(['is_national' => 1, 'is_visible' => 1])
        ->orderBy('display_order', 'asc')
        ->get();
        
        $international = self::select('id', 'name', 'icon_url', 'is_national')
        ->where(['is_national' => 0, 'is_visible' => 1])
        ->orderBy('display_order', 'asc')
        ->get();
        
        $all = $national->merge($international);
        
        return $all;
    }

    static function getAvailableIDs()
    {

        $availableSources = self::select('id')->where(['is_visible' => 1])->get();
        $availableIDs = [];

        foreach($availableSources as $source){
            $availableIDs[] = $source->id;
        }

        return $availableIDs;
    }
}
