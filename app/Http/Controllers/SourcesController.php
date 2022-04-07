<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sources;

use Laravel\Lumen\Routing\Controller as BaseController;

class SourcesController extends BaseController
{

    public $requestController;

    public function __construct(){
       $this->requestController = new RequestController();
    }

    public function getAvailable(Request $request) {

        if(!$this->requestController->isValid($request)) { return; }

        return response()->json(Sources::getAvailable());
    }
}