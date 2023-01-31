<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Historique;
use App\Http\Controllers\Controller;
use App\Invitation;
use App\Mail\Invite;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
   public function addCompany(Request $request){
    Gate::authorize('access',Auth::user());
    $request->validate([
        'name'  => 'required|string|unique:companies|max:255',
        'email' => 'required|max:255',
        'phone' => 'required',
    ]);
    try{
    $company = Company::create([
        'name'     => $request->name,
        'email'     => $request->email,
        'phone'     => $request->phone,
        'address'     => $request->address,
    ]);
    $response = [
        'message' => 'company added successfully',
    ];
    return response()->json($response, 201);
}
catch(Exception $e){
    $response = [
        'message' => 'company not added',
    ];
    return response()->json($response, 404);
}
   }
   public function getAllCompanies()
    {
        Gate::authorize('access',Auth::user());
        $companies = Company::paginate(15);

        return response()->json($companies, 200);
    
    }
   public function showDetail($id)
    {
         Gate::authorize('accessCompany',Company::find($id));
        $company = Company::find($id);
        $employees = $company->users;
        $response=[
            'company' =>$company,
            'employees' => $employees,
        ];
        return response($response, 200);
    
    }
   public function show($id)
    {
        Gate::authorize('access',Auth::user());
        $company = Company::find($id);
        return response($company, 200);
    
    }
   public function update(Request $request,$id)
    {
        Gate::authorize('access',Auth::user());
        $this->validate($request, [
            'name' => ['required','string','max:255',Rule::unique('companies')->ignore($id)],
            'email' => 'required|max:255',
        ]);

        //get Company data
        $CompanyData = $request->all();
        //update Company data
    try {
        Company::find($id)->update($CompanyData);
            $response = [
                'message' => 'Company updated successfully',
            ];
            return response()->json($response, 200);
        } catch(Exception $e) { 
            $response = [
                'message' => 'Company not updated',
            ];
            return response()->json($response, 404);
            
        }
    
    }
   public function delete($id)
    {
        Gate::authorize('access',Auth::user());
        if(Company::find($id)->users->count()==0){
            Company::find($id)->delete();
            $response = [
                'message' => 'Company deleted successfully',
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'message' => 'Company not deleted',
            ];
            return response()->json($response, 404);
        }
    
    }
   public function invite(Request $request)
    {
        Gate::authorize('access',Auth::user());
        $request->validate([
            'email' => 'required|unique:users|max:255',
            'nom'  => 'required|string|max:255|alpha_dash',
        ]);
        try{
        $user = User::create([
            'nom'     => $request->nom,
            'email'    => $request->email,
            'is_admin'    => 0,
            'verified'    => -1,
            'company_id'    => $request->company_id,
        ]);
        $invitation = Invitation::create([
            'employee_id'     => $user->id,
            'admin_id'    => Auth::user()->id,
            'status'    => 1,
            'company_id'    => $request->company_id,
        ]);
        Historique::create([
            'employee_id'     =>  $user->id,
            'admin_id'    => Auth::user()->id,
            'status'    => 'Invite',
            'company_id'    => $request->company_id,
        ]);
        Mail::to($request->email)->send(new Invite($request->nom,Auth::user()->nom,$user->id,Auth::user()->id));
        $response=[
            'message'=>'Invitation send successfully',
        ];
        return response()->json($response, 201);
    }
    catch(Exception $e){
        $response = [
            'message' => $e->getMessage(),
            // 'message' => 'Employee Not added',
        ];
        return response()->json($response, 404);
    }
    
    }
    public function getCompany(){

        $company = Auth::user()->company;
        return response($company, 200);
    }
}
