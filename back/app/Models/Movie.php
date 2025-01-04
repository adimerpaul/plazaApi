<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'adult',
        'backdrop_path',
        'budget',
        'homepage',
        'imdb_id',
        'original_language',
        'original_title',
        'overview',
        'popularity',
        'poster_path',
        'release_date',
        'revenue',
        'runtime',
        'status',
        'tagline',
        'title',
        'video',
        'vote_average',
        'vote_count',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function productionCompanies()
    {
        return $this->belongsToMany(ProductionCompany::class);
    }

    public function productionCountries()
    {
        return $this->belongsToMany(ProductionCountry::class);
    }

    public function spokenLanguages()
    {
        return $this->belongsToMany(SpokenLanguage::class);
    }
}
