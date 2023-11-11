<?php

namespace App\Http\Controllers;

use App\Models\MapPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MapController extends Controller
{
    /**
     * Display a listing of the map pins.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mapPins = MapPin::all();

        return response()->json(['map_pins' => $mapPins]);
    }

    /**
     * Store a newly created map pin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

}
