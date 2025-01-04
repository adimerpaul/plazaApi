<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionCountry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'iso_3166_1',
        'name',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
