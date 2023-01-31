<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'email', 'password','address','phone','date_of_birth','is_admin','verified','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function invitations()
    {
        return $this->hasMany('App\Invitation','admin_id');
    }
    public function invitation()
    {
        return $this->hasOne('App\Invitation','employee_id')->where('status','=', 1);
    
    }

    public function adminHistoriques()
    {
        return $this->hasMany('App\Historique','admin_id');
    }
}
