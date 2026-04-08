<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }
}
