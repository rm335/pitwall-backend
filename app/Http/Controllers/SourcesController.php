<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sources;

use Laravel\Lumen\Routing\Controller as BaseController;

class SourcesController extends BaseController
{
    public function getAvailable(Request $request) {
        return response()->json(Sources::getAvailable());
    }
}