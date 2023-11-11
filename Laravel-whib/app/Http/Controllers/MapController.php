<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function getMapPins()
    {
        try {
            $mapPins = json_decode(Storage::get('map_pins.json'), true);
        } catch (\Exception $e) {
            // Handle the exception, e.g., log it or return an error response
            return response()->json(['error' => 'Error retrieving map pins.'], 500);
        }

        return response()->json($mapPins);
    }
}
