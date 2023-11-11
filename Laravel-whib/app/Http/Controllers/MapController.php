<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getMapPins()
    {
        $mapPins = config('map_pins');

        return response()->json($mapPins);
    }
}
