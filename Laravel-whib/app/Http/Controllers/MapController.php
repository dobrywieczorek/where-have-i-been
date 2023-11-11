<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function getMapPins()
    {
        $mapPins = config('map_pins');

        return response()->json($mapPins);
    }
}
