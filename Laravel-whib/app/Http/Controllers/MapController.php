<?php

namespace App\Http\Controllers;

use App\Models\MapPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MapController extends Controller
{
    /**
     * Display a listing of the user's map pins, filtered by category and name.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $category = $request->input('category');
        $pin_name = $request->input('pin_name');

        if ($category || $pin_name) {
            $mapPins = MapPin::getUserPinsByCategoryAndName($userId, $category, $pin_name);
        } else {
            $mapPins = MapPin::getUserPins($userId);
        }

        return response()->json(['map_pins' => $mapPins]);
    }

    /**
     * Store a newly created map pin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pin_name' => 'required|string',
            'description' => 'required|string',
            'favourite' => 'required|bool',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'user_id' => "required|string",
            'category' => "required|string",
            // Add other validation rules as needed
        ]);

        $mapPin = MapPin::create($request->all());

        return response()->json(['map_pin' => $mapPin], 201);
    }

    /**
     * Display the specified map pin.
     *
     * @param  \App\Models\MapPin  $mapPin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MapPin $mapPin)
    {
        return response()->json(['map_pin' => $mapPin]);
    }

    /**
     * Update the specified map pin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MapPin  $mapPin
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, MapPin $mapPin)
    {
        $this->validate($request, [
            'pin_name' => 'string',
            'description' => 'string',
            'favourite' => 'bool',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'user_id' => 'string',
            'category' => 'string',
            // Add other validation rules as needed
        ]);

        $mapPin->update($request->all());

        return response()->json(['map_pin' => $mapPin]);
    }

    /**
     * Remove the specified map pin from storage.
     *
     * @param  \App\Models\MapPin  $mapPin
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(MapPin $mapPin)
    {
        $mapPin->delete();

        return response()->json(null, 204);
    }
}
