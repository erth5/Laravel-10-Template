<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Lang extends Model
{
    use HasTranslations, HasFactory;

    protected $fillable = [
        'country_code',
        'flag',
        'abbreviation'
    ];

    public $translatable = ['language'];

    public function scopeFullAssigned($query)
    {
        return $query->where('user_id' != null && 'person_id' != null);
    }

    public function scopeAssigned($query)
    {
        return $query->where('user_id' != null || 'person_id' != null);
    }

    public function scopeUnassigned($query)
    {
        return $query->where('user_id', null && 'person_id', null);
    }

    public function person()
    {
        return $this->belongsToMany(Person::class);
    }
}
