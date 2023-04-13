<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Person;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Scopes\SoftDeletesScope;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaracraftTech\LaravelDateScopes\DateScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable, HasRoles, DateScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /* Global Scope */
    protected static function boot()
    {
        parent::boot();
        /* Standardmäsig Softdeletes anschalten */
        // static::addGlobalScope(new SoftDeletesScope);
    }

    /**
     * this data can't be accessed directly.
     *
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function addPermission($permissionName)
    {
        return $this->givePermissionTo($permissionName);
    }

    public function addAllPermission()
    {
        return $this->givePermissionTo(Permission::all());
    }

    public function hasPermission($permissionName)
    {
        return $this->hasPermissionTo($permissionName);
    }
    public function proofUserCan($permissionName)
    {

        return $this->hasPermissionTo($permissionName);
    }

    public function removePermission($permissionName)
    {
        return $this->revokePermissionTo($permissionName);
    }

    // Bereits integriert
    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class);
    // }

    /**
     * Relationship: get person associated with user
     */
    public function person()
    {
        return $this->hasOne(Person::class, 'user_id', 'id');
    }

    /** Relationship: get Images through person */
    public function image()
    {
        return $this->hasManyThrough(Image::class, Person::class);
    }
}
