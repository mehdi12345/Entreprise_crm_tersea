<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name','phone','email','address'
    ];
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function invitations()
    {
        return $this->hasMany('App\Invitation');
    }
}
