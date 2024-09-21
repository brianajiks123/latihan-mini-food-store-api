<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    // Get All User
    public function index()
    {
        $all_user = User::paginate(3);
        $msg = 'Get All User Success.';

        return $this->sendResponse(UserResource::collection($all_user)->resource, $msg);
    }

    // Get User by Id
    public function show(User $user)
    {
        $msg = 'Get Data Success.';

        return $this->sendResponse(new UserResource($user), $msg);
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

        $msg = 'Add User Success.';

        return $this->sendResponse(new UserResource($user), $msg);
    }

    // Update User
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated_data = $request->validated();

        // $img_name = null;

        // if ($request->photo) {
        //     $img_name = time() . '.' . $request->file('photo')->extension();
        //     $request->photo->storeAs('public/images', $img_name);

        //     // Delete Old Photo
        //     $old_path = storage_path('app/public/images/' . $user->photo);

        //     if (File::exists($old_path)) {
        //         File::delete($old_path);
        //     }

        //     $user->photo = $img_name;
        // }

        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];

        if ($request->password != "") {
            $user->password = Hash::make($request->password);
        }

        // $user->address = $request->address;
        $user->update();

        $msg = 'Update User Success.';

        return $this->sendResponse(new UserResource($user), $msg);
    }

    // Delete User
    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();

            return response()->noContent();
        } catch (\Exception $e) {
            $msg = $e->getMessage();

            return $this->sendError('Error Delete: ', $e->getMessage(), 500);
        }
    }
}
