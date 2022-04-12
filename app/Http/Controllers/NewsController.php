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

        if (array_key_exists('x-app-sources', $headers)) {

            $sources = explode(',', $headers['x-app-sources'][0]);

            if (!empty($sources[0])) {
                return response()->json(News::getFromSources($sources));
            }
        }

        return;
    }

    public function readItem(Request $request) {

        if(!$this->requestController->isValid($request)) { return; }

        if (!empty($request->input('id'))) {
            News::where('id', $request->input('id'))->increment('times_read', 1);
        }

        return response()->json(['success' => 'success'], 200);
    }
}