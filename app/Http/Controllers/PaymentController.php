<?php

namespace App\Http\Controllers;

use App\Http\Enums\PaymentStatus;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{

    public function show(Booking $booking): JsonResponse
    {
        return response()->json(PaymentResource::collection($booking->payment), 200);
    }

    public function store(StorePaymentRequest $request, Booking $booking) :JsonResponse
    {
        $data = $request->validated();
        $data['booking_id'] = $booking->id;
        $data['status'] = $data['status'] ?? PaymentStatus::PENDING->value;

        $payment = Payment::create($data);

        return response()->json(new PaymentResource($payment), 200);
    }

}
