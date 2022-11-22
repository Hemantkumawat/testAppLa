<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::query()->simplePaginate($request->per_page ?? 10);
        return response()->json(["message" => 'Users list', "data" => compact('users')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $updated = $user->update($request->validated());
        if (!$updated)
            return response()->json(['message' => "Unable to update Record", "data" => compact('user')], 500);
        $user = User::query()->findOrFail($id);
        return response()->json(["message" => "User Detail Updated Successfully", "data" => compact('user')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return response()->json(["message" => "User Deleted Successfully", "data" => compact('user')]);
    }
}
