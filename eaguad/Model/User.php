<?php

namespace EAguad\Model;

use EAguad\Enum\UserRole;
use EAguad\Traits\GenerateUUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, GenerateUUID, HasApiTokens;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'is_active', 'permission_view', 'permission_signatory', 'permission_admin', 'permission_approver'
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
        return $query->whereRole(UserRole::Signatory);
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->is_active;
    }

    /**
     * @return string
     */
    public function isViewer() : string
    {
        return $this->permission_view;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->permission_admin;
    }

    /**
     * @return bool
     */
    public function isSignatory() : bool
    {
        return $this->permission_signatory;
    }

    public function isApprover()
    {
        return $this->permission_approver;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function costCentres()
    {
        return $this->belongsToMany(CostCentre::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeApprover($query)
    {
        return $query->where('role', 'approver');
    }
}
