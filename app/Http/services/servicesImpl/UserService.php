<?php

namespace App\Http\services\servicesImpl;

use App\Http\Resources\UserResource;
use App\Http\services\CrudServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class UserService implements CrudServiceInterface
{
    protected function authorizeUser($id): bool
    {
        $user = Auth::user();
        return $user->id == $id;
    }

    public function update(int $id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }
        if (!$this->authorizeUser($user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validatedData = $request->validate([
            'first_name' => 'nullable|string|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'nullable|string|regex:/^[a-zA-Z\s]+$/'
        ]);
        if (isset($validatedData['first_name'])) {
            $user->first_name = $validatedData['first_name'];
        }
        if (isset($validatedData['last_name'])) {
            $user->last_name = $validatedData['last_name'];
        }
        $user->save();
        return response()->json(['message' => 'User updated successfully']);
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }
        if (!$this->authorizeUser($user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getById(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }
        return response()->json(['user' => new UserResource($user)]);
    }

    public function getAll()
    {
        $users = User::all();
        return UserResource::collection($users);
    }
}
