<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{
    public function index(Booking $booking): JsonResponse
    {



        //$booking = $booking::with('payment')->get();
        //dd($booking->payment);
        //dd($booking::with('payment')->get());


        //$payments = $booking->where('id');
        return response()->json(PaymentResource::collection($booking->payment), 200);

    }

}
