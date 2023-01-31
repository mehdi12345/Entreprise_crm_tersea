<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = [
        'employee_id','admin_id','status','company_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\User','employee_id');
    }
    
    public function company()
    {
        return $this->belongsTo('App\Company','company_id');
    }
}
