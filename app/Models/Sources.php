<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sources extends Model
{
    protected $table = 'sources';

    static function getAvailable()
    {
        $national = self::select('id', 'name', 'icon_url', 'is_national')->where(['is_national' => 1])->orderBy('display_order', 'asc')->get();
        $international = self::select('id', 'name', 'icon_url', 'is_national')->where(['is_national' => 0])->orderBy('display_order', 'asc')->get();
        $all = $national->merge($international);
        return $all;
    }
}
