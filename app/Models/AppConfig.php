<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    protected $table = 'app_config';

    static function getAvailable()
    {
        return self::get();
    }

    static function get($key) {
        return self::where('key', $key)->first();
    }
}
