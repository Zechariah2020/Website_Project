<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $result = Address::all();
        return AddressResource::collection($result);
    }

    public function show($id)
    {
        $address = Address::findOrFail($id);
        if ($address) {
            return new AddressResource($address);
        } else {
            return response()->json([
                'result' => 'Address not found.'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = new Address;
        $address->user_id = $user_id;
        $address->description = $request->description;
        $address->province = $request->province;
        $address->city = $request->city;
        $result = $address->save();
        if ($result) {
            return response()->json([
                'result' => 'Address added successfully.'
            ], 200);
        } else {
            return response()->json([
                'result' => 'An error has occured.'
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $address = Address::find($id);
        $address->user_id = $user_id;
        $address->description = $request->description;
        $address->province = $request->province;
        $address->city = $request->city;
        $result = $address->update();
        if ($result) {
            return response()->json([
                'result' => 'Address updated successfully.'
            ], 200);
        } else {
            return response()->json([
                'result' => 'An error has occured.'
            ], 401);
        }
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        $result = $address->delete();
        if ($result) {
            return response()->json([
                'result' => 'Address deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'result' => 'An error has occured.'
            ], 401);
        }
    }
}
