<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        try {
            $user_id = Auth::user()->id;
            $validated = Validator::make($request->all(), [
                'description' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'city' => 'required|string|max:255'
            ]);

            if ($validated->fails()) {
                $error = $validated->errors()->all()[0];
                return response()->json([
                    'status' => 'false',
                    'message' => $error,
                    'data' => []
                ], 422);
            } else {
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
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user_id = Auth::user()->id;
            $validated = Validator::make($request->all(), [
                'description' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'city' => 'required|string|max:255'
            ]);

            if ($validated->fails()) {
                $error = $validated->errors()->all()[0];
                return response()->json([
                    'status' => 'false',
                    'message' => $error,
                    'data' => []
                ], 422);
            } else {
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
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
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
