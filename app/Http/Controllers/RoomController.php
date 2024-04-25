<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'number' => 'integer|exists:rooms,number',
            'room_type_id' => 'integer|exists:room_types,id'
        ]);

        $rooms = Room::where($request->only(['number', 'room_type_id']))->get();

        return response()->json(RoomResource::collection($rooms), 200);
    }
}
