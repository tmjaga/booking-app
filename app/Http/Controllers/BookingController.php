<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class BookingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'number' => 'integer|exists:rooms,number',
            'customer' => 'regex:/^[a-z0-9\s]+$/i|max:100'
        ]);

        $bookingQuery = Booking::query();

        $bookingQuery->when(isset($data['number']), function (Builder $bookingQuery) use ($data) {
            $bookingQuery->whereHas('room', function (Builder $query) use ($data) {
                $query->where('number', $data['number']);
            });
        });

        $bookingQuery->when(isset($data['customer']), function (Builder $bookingQuery) use ($data) {
            $bookingQuery->whereHas('customer', function (Builder $query) use ($data) {
                $query->where('customer_name', 'like', '%' . $data['customer'] . '%');
            });
        });

        $bookings = $bookingQuery->get();

        return response()->json(BookingResource::collection($bookings), 200);
    }

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $data = $request->validated();

        // check if Room have any bookings for provided check_in and check_out date
        $roomAvailable = Room::find($data['room_id'])->roomAvaliable($data['check_in_date'], $data['check_out_date']);
        if (!$roomAvailable) {
            return response()->json(['message' => 'This Room is not available for this period'], 430);
        }

        $booking = Booking::create($data);

        return response()->json(new BookingResource($booking), 200);
    }

    public function cancel(Booking $booking): JsonResponse
    {

        $booking->payment()->delete();
        $booking->delete();

        return response()->json(['message' => 'Booking canceled'], 200);
    }
}
