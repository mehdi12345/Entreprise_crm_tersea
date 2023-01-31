<?php

namespace App\Http\Controllers\User;

use App\Historique;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function validateUser(Request $request,$id){
        try{
            $user=User::findOrFail($id);
            if($user->invitation!=null){
            if($user->verified!=1){
                
        $user->update(['verified' => 0]);
        Historique::create([
            'employee_id'     =>  $user->id,
            'admin_id'    => $request->admin_id, //get the admin that invite the employee
            'status'    => 'Validate',
            'company_id'    => $user->company_id,
        ]);
        $response = [
            'message' => 'Employee validated successfully',
        ];
        return response()->json($response, 200);
            }else{
                $response = [
                    'message' => 'Employee Already verified',
                ];
                return response()->json($response, 404); 
            }
        }else{
            $response = [
                'message' => 'Invitation is Not Active',
            ];
            return response()->json($response, 404);
        }
        }catch(Exception $e){
            $response = [
                'message' => 'Employee Not Found',
            ];
            return response()->json($response, 404);
        }
    }
    public function confirmUser(Request $request,$id){
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        try{
            $user=User::findOrFail($id);
            if($user->verified!=1){
                
        $user->update([
            'password' => Hash::make($request->password),
            'verified' => 1,
            ]);
            Historique::create([
                'employee_id'     =>  $user->id,
                'admin_id'    => $request->admin_id, //get the admin that invite the employee
                'status'    => 'Confirm',
                'company_id'    => $user->company_id,
            ]);
        $response = [
            'user'=>$user,
            'message' => 'Employee validated successfully',
        ];
        return response()->json($response, 200);
            }else{
                $response = [
                    'message' => 'Employee Already verified',
                ];
                return response()->json($response, 404); 
            }
        }catch(Exception $e){
            $response = [
                'message' => 'Employee Not Found',
            ];
            return response()->json($response, 404);
        }
    }
    
    public function getAllEmployee()
    {
        Gate::authorize('access',Auth::user());
        $employees = User::where('is_admin',0)->get()->map(function ($employee) {
            return [ 
                'id'=>$employee->id,
                'nom'=>$employee->nom,
                'address'=>$employee->address,
                'phone'=>$employee->phone,
                'email'=>$employee->email,
                'company_name'=>$employee->company?$employee->company->name:'',
                'date_of_birth'=>$employee->date_of_birth,
                'verified'=>$employee->verified,
            ];
        });

        return response($employees, 200);
    
    }
    
    public function getEmployee()
    {
        $company_id=Auth::user()->company_id;
        $employees = User::where([['is_admin',0],['company_id',$company_id]])->get()->map(function ($employee) {
            return [ 
                'id'=>$employee->id,
                'nom'=>$employee->nom,
                'address'=>$employee->address,
                'phone'=>$employee->phone,
                'email'=>$employee->email,
                'company_name'=>$employee->company?$employee->company->name:'',
                'date_of_birth'=>$employee->date_of_birth,
                'verified'=>$employee->verified,
            ];
        });

        return response($employees, 200);
    
    }
}
