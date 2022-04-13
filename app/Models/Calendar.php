<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    static function getAll()
    {
        return self::orderBy('start', 'asc')->get();
    }

    static function getRaces()
    {
        $result = self::select(
            'start',
            'end',
            'gmt_offset',
            'status',
            'type',
            'title',
            'circuit_short_name',
            'location',
            'country',
            'country_flag_url',
            'circuit_wiki_url',
            'winner',
            'round',
            'circuit_light_img_url',
            'circuit_dark_img_url',
            'created_at')
            ->whereNotNull('round')
            ->orderBy('start', 'asc')
            ->get();

        $collection = collect($result);

        $grouped = $collection->groupBy('round');

        return $grouped->all();
    }
}


