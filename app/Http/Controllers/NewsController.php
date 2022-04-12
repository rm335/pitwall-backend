<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\News;

use Laravel\Lumen\Routing\Controller as BaseController;

class NewsController extends BaseController
{

    public $requestController;

    public function __construct() {
       $this->requestController = new RequestController();
    }

    public function getAvailable(Request $request) {

        if(!$this->requestController->isValid($request)) { return; }

        $headers = $request->headers->all();

        if (array_key_exists('sources', $headers)) {

            $sources = explode(',', $headers['sources'][0]);
            
            if (!empty($sources[0])) {
                return response()->json(News::getFromSources($sources));
            }
        }

        return;
    }
}