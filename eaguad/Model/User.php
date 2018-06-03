<?php

namespace EAguad\Model;

use EAguad\Traits\GenerateUUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, GenerateUUID;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'is_signatory', 'is_admin', 'is_active'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeSignatory($query)
    {
        return $query->whereIsSignatory(true);
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->is_active;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->is_admin;
    }

    /**
     * @return bool
     */
    public function isSignatory() : bool
    {
        return $this->is_signatory;
    }
}
