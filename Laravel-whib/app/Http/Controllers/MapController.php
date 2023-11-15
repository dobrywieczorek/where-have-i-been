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
        $pinName = $request->input('pin_name');

        $mapPins = (new MapPin)->getUserPins($userId, $category, $pinName);

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
        $this->validateMapPin($request);

        $mapPin = Auth::user()->mapPins()->create($request->all());

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
        $this->validateMapPin($request);

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

    /**
     * Validate the map pin data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateMapPin(Request $request)
    {
        $this->validate($request, [
            'pin_name' => 'string|required',
            'description' => 'string|required',
            'favourite' => 'boolean|required',
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
            'user_id' => 'int|required',
            'category' => 'string|required',
            // Add other validation rules as needed
        ]);
    }
}
