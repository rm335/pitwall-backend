<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sources;

use Laravel\Lumen\Routing\Controller as BaseController;

class SourcesController extends BaseController
{

    public function getAvailable(Request $request) {

        if(!$this->isValidRequest($request)){ return; }

        return response()->json(Sources::getAvailable());
    }

    private function isValidRequest(Request $request) {

        $headers = $request->headers->all();        
        $appConfig = new AppConfigController();
     
        // Check if x-appconfg-key key is equal to the AppConfig key
        if (!array_key_exists('x-appconfg-key', $headers)) { return false; }
        if ($headers['x-appconfg-key'][0] != $appConfig->get('x-appconfg-key')) { return false; }

        // Check if x-f1-key key is equal to the AppConfig key
        if (!array_key_exists('x-f1-key', $headers)) { return false; }
        if ($headers['x-f1-key'][0] != $appConfig->get('x-f1-key')) { return false; }

        return true;
    }    
}