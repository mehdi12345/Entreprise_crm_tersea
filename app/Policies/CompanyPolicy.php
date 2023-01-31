<?php

namespace App\Policies;

use App\Company;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    
    public function accessCompany(User $user,Company $company)
    {
        if($user->is_admin)
            return $user->is_admin;
        return $user->company_id==$company->id;
    }
}
