<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpokenLanguage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'english_name',
        'iso_639_1',
        'name',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
