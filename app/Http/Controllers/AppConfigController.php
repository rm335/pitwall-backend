<?php

namespace App\Http\Controllers;
use App\Models\AppConfig;

use Laravel\Lumen\Routing\Controller as BaseController;

class AppConfigController extends BaseController
{
    public function get($key) {
        return AppConfig::get($key)->value;
    }
}