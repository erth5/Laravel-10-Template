<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'path',
        'extension',
    ];

    protected $dates = ['deleted_at'];

    // reverse changed column name to original
    const CREATED_AT = 'upload_time';

    const UPDATED_AT = 'update_time';

    const DELETED_AT = 'remove_time';

    /** don't forget, after scope there need a get or first
     * $completedProjects = Project::completed()->get();
     * This scopes are static ::, but can also non-static ->
     * */

    /**
     * Scopes:  Select images that are have a specific relation to user and person
     *
     * @return query
     */
    public function scopeFullAssigned($query)
    {
        return $query->where('person_id' != null && 'user_id' != null);
    }

    public function scopeAssigned($query)
    {
        return $query::where('person_id' != null || 'user_id' != null);
    }

    public function scopeUnassigned($query)
    {
        return $query::where('person_id', null && 'user_id', null);
    }

    /**
     * Scope:  Select images that have a specific relation to a user
     *
     * @return query
     */
    public function scopeUserUnassigned($query)
    {
        return $query::where('user_id', null);
    }

    public function scopeUserAssigned($query)
    {
        return $query::where('user_id' != null);
    }

    /**
     * Scope:  Select images that have a specific relation to a person
     *
     * @return query
     */
    public function scopePersonUnassigned($query)
    {
        return $query::where('person_id', null);
    }

    public function scopePersonAssigned($query)
    {
        return $query::where('person_id' != null);
    }

    /**
     * Relationship: get person that owns images
     */
    public function person()
    {
        return $this->belongsTo(Person::class); //foreign:id, own:person_id
    }

    /** Relationship: has user through person
     * no documented for belongs
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
