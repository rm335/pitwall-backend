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
        
        if (!array_key_exists('x-f1-key', $headers)) { return false; }
        if ($headers['x-f1-key'][0] != $appConfig->get('x-f1-key')) { return false; }

        return true;
    }
}