<?php

namespace App\Modules\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company', 'address', 'city', 'state', 'zip', 'country', 'phone', 'web'
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
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Roles formatted
     * 
     * @return [type] [description]
     */
    public function getRolesFormattedAttribute()
    {
        $roles = $this->roles;
        $list = [];
        foreach ($roles as $key => $role) {
            $list[] = $role->name;
        }

        return implode(', ', $list);
    }

    /**
     * Hack.
     * 
     * @return [type] [description]
     */
    public function getRolesFirstAttribute()
    {
        $roles = $this->roles;
        $id = false;
        foreach ($roles as $key => $role) {
            $id = $role->id;
        }
        return $id;
    }

    /**
     * Does the user have a particular role?
     *
     * @param $name
     * 
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * Assign a role to the user.
     *
     * @param $role
     * 
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * Remove a role from a user.
     *
     * @param $role
     * 
     * @return mixed
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }
}
