<?php

namespace App\Http\Controllers\Historique;

use App\Historique;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HistoriqueController extends Controller
{
    public function getHistorique()
    {
        Gate::authorize('access',Auth::user());
        $historiques = Historique::all()->map(function ($historique) {
            if($historique->status=='Active' || $historique->status=='Inactive'){
            return [ 
                'date'=>$historique->created_at->format('d-m-Y - H:i'),
                'action'=>'Admin '.$historique->admin->nom.' '.$historique->status.' the invitation for '.$historique->employee->nom,
            ];
        }else if($historique->status=='Validate' || $historique->status=='Confirm'){
            return [ 
                'date'=>$historique->created_at->format('d-m-Y - H:i'),
                'action'=>$historique->employee->nom.' has '.$historique->status.' the invitation'
            ];
        }
        else{
            return [ 
                'date'=>$historique->created_at->format('d-m-Y - H:i'),
                'action'=>'Admin '.$historique->admin->nom.' invite '.$historique->employee->nom.' to join the company '.$historique->company->name
            ];
        }
        });

        return response($historiques, 200);
    
    }
}
