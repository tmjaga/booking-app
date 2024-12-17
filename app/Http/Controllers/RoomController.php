<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'number' => 'integer|exists:rooms,number',
            'room_type_id' => 'integer|exists:room_types,id',
            'status' =>'room_status'
        ]);

        // filter on accessor (calculated) field status
        $rooms = Room::where($request->only(['number', 'room_type_id']))->get();

        if (isset($data['status'])) {
            $rooms = $rooms->filter(function (Room $room) use ($data) {
                return $room->status == $data['status'];
            });
        }

        return RoomResource::collection($rooms)->response();
    }

    public function show(int $roomNumber): JsonResponse
    {
        $room = Room::where('number', $roomNumber)->firstOrFail();

        return (new RoomResource($room))->response();
    }

    public function store(StoreRoomRequest $request): JsonResponse
    {
        $room = Room::create($request->all());

        return (new RoomResource($room))->response();
    }
}
