<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    public function users()
    {
        // $users = app('db')->table('users')->get();
        // $users = DB::table('users')->get();
        $users = User::all();

        return UserResource::collection($users);
    }

    public function showUser($id)
    {
        // $user = app('db')->table('users')->where('id', $id)->first();
        // $user = DB::table('users')->where('id', $id)->first();
        $user = User::find($id);

        return new UserResource($user);
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'user_name' => 'required|min:3',
                'email'     => 'required|email|unique:users'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }

        try {
            // app('db')->table('users')->where('id', $id)->update([
            //     'full_name'  => trim($request->full_name),
            //     'user_name'  => strtolower(trim($request->user_name)),
            //     'email'      => trim($request->email),
            //     'updated_at' => Carbon::now()
            // ]);

            // DB::table('users')->where('id', $id)->update([
            //     'full_name'  => trim($request->full_name),
            //     'user_name'  => strtolower(trim($request->user_name)),
            //     'email'      => trim($request->email),
            //     'updated_at' => Carbon::now()
            // ]);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Resource updated successfully'
            // ], 200);

            $user = User::find($id);
            $user->update($request->all());

            return new UserResource($user);
        } catch (Exception $e) {
            return repsonse()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteUser($id)
    {
        // app('db')->table('users')->where('id', $id)->delete();
        // DB::table('users')->where('id', $id)->delete();
        User::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200);
    }
}
