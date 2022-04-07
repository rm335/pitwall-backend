<?php

namespace App\Http\Controllers;
use App\Models\AppConfig;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class AppConfigController extends BaseController
{

    public function getAvailable(Request $request) {

        $headers = $request->headers->all();        
        $appConfig = new AppConfigController();
     
        // Check if x-appconfg-key key is equal to the AppConfig key
        
        $xMinimumAppBuildKey = "x-minimum-app-build";
        $xAppBuildKey = "x-app-build";

        if (!array_key_exists($xAppBuildKey, $headers)) { return; }
        if (floatval($headers[$xAppBuildKey][0]) < floatval($this->get($xMinimumAppBuildKey))) { return; }

        return response()->json(AppConfig::getAvailable());
    }

    public function get($key) {
        return AppConfig::getValueForKey($key)->value;
    }
}