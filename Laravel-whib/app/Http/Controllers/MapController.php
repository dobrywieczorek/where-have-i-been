<?php

namespace App\Http\Controllers;

use App\Models\MapPin;
use App\Models\Trip;
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
        $isTrip = $request->input('is_trip');

        $mapPins = (new MapPin)->getUserPins($userId, $category, $pinName, $isTrip);

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
        $request['favourite'] = filter_var($request['favourite'], FILTER_VALIDATE_BOOLEAN);

        $this->validate($request, [
            'pin_name' => 'required',
            'description' => 'nullable',
            'favourite' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',
            'category' => 'required',
        ]);

        // Get the authenticated user
        if ($user = auth()->user()) {
            // Create a new map pin associated with the authenticated user
            $mapPin = MapPin::create([
                'pin_name' => $request->input('pin_name'),
                'description' => $request->input('description'),
                'favourite' => $request->input('favourite'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'user_id' => $user->id,
                'category' => $request->input('category'),
            ]);

            // Return a JSON response with the created map pin and a status code of 201 (Created)
            return response()->json(['map_pin' => $mapPin], 201);
        }
        // If the user is not authenticated, you might want to handle this case accordingly
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Display the specified map pin.
     *
     * @param  \App\Models\MapPin  $mapPin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, MapPin $mapPin)
    {
        $request['favourite'] = filter_var($request['favourite'], FILTER_VALIDATE_BOOLEAN);


        $user = auth()->user();

        // Check if the user is authenticated
        if ($user) {
            // Retrieve map pins based on the authenticated user's ID
            $mapPins = MapPin::where('user_id', $user->id)->get();

            // Return a JSON response with the map pins
            return response()->json(['map_pins' => $mapPins]);
        }

        // If the user is not authenticated, return an unauthorized response
        return response()->json(['error' => 'Unauthorized'], 401);
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
        $request['favourite'] = filter_var($request['favourite'], FILTER_VALIDATE_BOOLEAN);
        $request['IsTrip'] = filter_var($request['IsTrip'], FILTER_VALIDATE_BOOLEAN);

        $this->validate($request, [
            'pin_name' => 'required',
            'description' => 'nullable',
            'favourite' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',
            'category' => 'required',
            'IsTrip' => 'required|boolean',
            'TripDate' => 'nullable|date',
        ]);

        $user = auth()->user();

        if ($user) {
            if ($mapPin->user_id == $user->id) {
                if (!$mapPin->IsTrip) {
                    $mapPin->update($request->all());
                    return response()->json(['map_pin' => $mapPin]);
                } else {
                    return response()->json(['error' => 'Forbidden: Cannot update trips.'], 403);
                }
            }
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Toggle the 'favourite' status of the specified map pin.
     *
     * @param \App\Models\MapPin $mapPin
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFavourite(Request $request,MapPin $mapPin)
    {
        $request['favourite'] = filter_var($request['favourite'], FILTER_VALIDATE_BOOLEAN);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the user is authenticated
        if ($user) {
            // Check if the map pin belongs to the authenticated user
            if ($mapPin->user_id == $user->id) {
                // Toggle the 'favourite' status
                $mapPin->update(['favourite' => !$mapPin->favourite]);

                // Return a JSON response with the updated map pin
                return response()->json(['map_pin' => $mapPin]);
            }

            // If the map pin does not belong to the authenticated user, return a forbidden response
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // If the user is not authenticated, return an unauthorized response
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Remove the specified map pin from storage.
     *
     * @param  \App\Models\MapPin  $mapPin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MapPin $mapPin)
    {
        $user = auth()->user();

        if ($user) {
            if (!$mapPin->IsTrip) {
                $mapPin->delete();
                return response()->json(null, 204);
            } else {
                return response()->json(['error' => 'Forbidden: Cannot delete trips.'], 403);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Set trip to true
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTrip(Request $request)
    {
        $request['favourite'] = filter_var($request['favourite'], FILTER_VALIDATE_BOOLEAN);
        $request['IsTrip'] = true; // Set IsTrip to true for trips

        $this->validate($request, [
            'pin_name' => 'required',
            'description' => 'nullable',
            'favourite' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',
            'category' => 'required',
            'IsTrip' => 'required|boolean',
            'TripDate' => 'nullable|date',
        ]);

        return response()->json(['map_pin' => $mapPin], 201);
    }
    public function getTrips(Request $request)
    {
        $userId = Auth::id();

        $mapPins = (new MapPin)->getUserPins($userId, null, null, true);

        return response()->json(['map_pins' => $mapPins]);
    }

}
