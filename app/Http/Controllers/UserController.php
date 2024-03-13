<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all()->toArray();
        return response()->json(['msg' => 'here is data', 'data' => $users]);

    }

    public function store(StoreUserRequest $request){

        User::create(['name' => $request->name, 'password' => bcrypt($request->password), 'email' => $request->email ]);
        return response()->json(['msg' => 'user created successfuly', 'status' => 200 ]);
    }

    public function show($id){
        $user = User::find($id)->toArray();
        return response()->json(['msg' => 'here is data', 'data' => $user]);
    }



    public function update(UpdateUserRequest $request, $id){

        $user = User::where('id', $id)->update(['name' => $request->name, 'password' => bcrypt($request->password)]);
        if(!$user){
            return response()->json(['error' => 'no user found', 'status' => 401]);
        }
        return response()->json(['success' => 'user updated successfully', 'status' => 200]);

    }

    public function destroy($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'no user found', 'status' => 401]);
        }
        $user->delete();
        return response()->json(['success' => 'user deleted successfully', 'status' => 200]);
    }


}
