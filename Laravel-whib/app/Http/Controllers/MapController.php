<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function getMapPins()
    {
        $mapPins = json_decode(Storage::get('map_pins.json'), true);

        return response()->json($mapPins);
    }
}
