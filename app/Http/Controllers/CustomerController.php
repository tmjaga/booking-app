<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\RoomResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'regex:/^[a-z0-9\s]+$/i|max:100',
            'email' => 'email|max:100',
            'phone_number' => 'integer'
        ]);

        $customers = Customer::where($request->only(['email', 'phone_number']));
        $customers->when($request->only(['name']), function ($customers, $value) {
            return $customers->where('name', 'like', '%' . $value['name'] . '%');
        });
        $customers = $customers->get();

        return response()->json(CustomerResource::collection($customers), 200);
    }

}
