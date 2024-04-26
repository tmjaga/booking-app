<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
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
}
