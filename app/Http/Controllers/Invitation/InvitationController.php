<?php

namespace App\Http\Controllers\Invitation;

use App\Historique;
use App\Http\Controllers\Controller;
use App\Invitation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InvitationController extends Controller
{
    public function getInvitation()
    {
        Gate::authorize('access',Auth::user());
        $invitations = Invitation::where('admin_id',Auth::user()->id)->get()->map(function ($invitation) {
            return [ 
                'id'=>$invitation->id,
                'employee_name'=>$invitation->employee?$invitation->employee->nom:'',
                'employee_email'=>$invitation->employee?$invitation->employee->email:'',
                'employee_phone'=>$invitation->employee?$invitation->employee->phone:'',
                'employee_address'=>$invitation->employee?$invitation->employee->address:'',
                'status'=>$invitation->status,
                'user_status'=>$invitation->employee?$invitation->employee->verified:'',
                'company_name'=>$invitation->company?$invitation->company->name:'',
            ];
        });

        return response($invitations, 200);
    
    }
    public function changeStatus(Request $request)
    {
        
        Gate::authorize('access',Auth::user());
        try{
            
        $invitation = Invitation::findOrFail($request->id);
        if($invitation->employee->verified!=1){
        $invitation->update(['status'=>$request->status]);
        }else{
            $response = [
                'message' => 'The employee has already verify his profile',
            ];
            return response($response, 404);
        }
        Historique::create([
            'employee_id'     => $invitation->employee->id,
            'admin_id'    => $invitation->admin->id,
            'status'    => $request->status==1?'Active':'Inactive',
            'company_id'    => $invitation->company->id,
        ]);
        $response = [
            'message' => 'Invitation status has change successfully',
        ];
        return response($response, 200);
        }
        catch(Exception $e){
            $response = [
                'message' => 'Invitation status has not change',
            ];
            return response($response, 404);
        }

    
    }
}
