<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'customer_name' => 'regex:/^[a-z0-9\s]+$/i|max:100',
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

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->all());

        return response()->json(new CustomerResource($customer), 200);
    }

}
