<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class FindSupportController extends Controller
{
    //

public function nearby(Request $request)
{
    // Get authenticated API user
    $user = auth('api')->user();

    if (!$user || !$user->latitude || !$user->longitude) {
        return response()->json([
            'success' => false,
            'message' => 'User location not available'
        ], 400);
    }

    $userLat = $user->latitude;  // Authenticated user's latitude
    $userLng = $user->longitude; // Authenticated user's longitude

    // Haversine formula to calculate distance (in km) from user to each location
    $locations = Location::selectRaw(
        "*, (6371 * acos(cos(radians(?))
        * cos(radians(latitude))
        * cos(radians(longitude) - radians(?))
        + sin(radians(?))
        * sin(radians(latitude)))) AS distance",
        [$userLat, $userLng, $userLat]
    )
        ->orderBy('distance', 'asc')
        ->get()
        ->map(function ($location) {
            // Round distance and overwrite the distance field
            $location->distance = round($location->distance, 2);
            return $location;
        });

    return response()->json([
        'success' => true,
        'message' => 'Nearby locations retrieved successfully',
        'total_locations' => $locations->count(),
        'data' => $locations
    ]);
}
}
