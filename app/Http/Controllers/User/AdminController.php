<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    public function getCurrentUser()
    {
        $user = auth()->user();

        return response($user, 201);
    
    }
    
    public function EditUser(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'email' => ['required','max:255',Rule::unique('users')->ignore($request->id)],
            //check if the email is duplicated with the ignore of the current user email
        ]);

        //get User data
        $UserData = $request->all();
        //update User data
    try {
        User::find($request->id)->update($UserData);
            $response = [
                'message' => 'User updated successfully',
            ];
            return response()->json($response, 200);
        } catch(Exception $e) {
            $response = [
                'message' => 'User not updated',
            ];
            return response()->json($response, 404);
        }
    
    }
    public function updatePassword(Request $request)
    {

        //validate user password data
        $fields = $this->validate($request, [
            'old_password' => 'required', //to confirm that he is the user who own the profile
            'password' => ['required', 'confirmed'],
        ]);

        //update user data
        $user = User::find(Auth::user()->id);
        if (Hash::check($fields['old_password'], $user->password)) {
            $user->password = Hash::make($fields['password']);
            $user->save();
            $response = [
                'message' => 'password changed successfully',
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'old_password does not match our data records',
            ];
            return response()->json($response, 404);
        }
    }
    public function getAllAdmin()
    {
        Gate::authorize('access',Auth::user());
        $admins = DB::table('users')->where('is_admin',1)->get()->map(function ($admin) {
            return [ 
                'id'=>$admin->id,
                'nom'=>$admin->nom,
                'address'=>$admin->address,
                'phone'=>$admin->phone,
                'email'=>$admin->email,
                'date_of_birth'=>$admin->date_of_birth,
            ];
        });

        return response($admins, 200);
    
    }
    public function addAdmin(Request $request)
    {
        Gate::authorize('access',Auth::user());
        $request->validate([
            'email' => 'required|unique:users|max:255',
            'nom'  => 'required|string|max:255|alpha_dash',
            'password' => 'required|confirmed',
        ]);
        try{
        User::create([
            'nom'     => $request->nom,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'    => $request->address,
            'is_admin'    => 1,
            'verified'    => 1,
            'date_of_birth'    => $request->date_of_birth,
            'password' => Hash::make($request->password)

        ]);
        
        $response=[
            'message'=>'Admin added successfully',
        ];
        return response()->json($response, 201);
    }
    catch(Exception $e){
        $response = [
            'message' => 'Admin Not added',
        ];
        return response()->json($response, 404);
    }
    
    }
    public function checkAdmin(){
        return ['isAdmin'=>Auth::user()->is_admin];
    }
}
