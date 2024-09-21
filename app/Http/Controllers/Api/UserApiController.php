<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    // Get All User
    public function index()
    {
        $all_user = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Get Data Success.',
            'data' => $all_user
        ]);
    }

    // Store User
    public function store(StoreUserRequest $request)
    {
        $validated_data = $request->validated();

        // $img_name = null;

        // if ($request->photo) {
        //     $img_name = time() . '.' . $request->file('photo')->extension();
        //     $request->photo->storeAs('public/images', $img_name);
        // }

        $user = User::create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
            // 'address' => $request->address,
            // 'photo' => $img_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Add User Success.',
            'data' => $user
        ]);
    }
}
