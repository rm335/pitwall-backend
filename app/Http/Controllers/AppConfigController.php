<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class AppConfigController extends BaseController
{
    public function getAppConfig() {
        return "hi";
    }
}