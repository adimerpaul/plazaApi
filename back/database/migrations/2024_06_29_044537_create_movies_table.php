<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->boolean('adult');
            $table->string('backdrop_path')->nullable();
            $table->integer('budget');
            $table->string('homepage')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('original_language');
            $table->string('original_title');
            $table->text('overview')->nullable();
            $table->float('popularity', 8, 2);
            $table->string('poster_path')->nullable();
            $table->date('release_date');
            $table->bigInteger('revenue');
            $table->integer('runtime')->nullable();
            $table->string('status');
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->boolean('video');
            $table->float('vote_average', 4, 2);
            $table->integer('vote_count');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movie_genre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
        });

        Schema::create('production_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('origin_country');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movie_production_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('production_company_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('production_company_id')->references('id')->on('production_companies')->onDelete('cascade');
        });

        Schema::create('production_countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso_3166_1');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movie_production_country', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('production_country_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('production_country_id')->references('id')->on('production_countries')->onDelete('cascade');
        });

        Schema::create('spoken_languages', function (Blueprint $table) {
            $table->id();
            $table->string('english_name');
            $table->string('iso_639_1');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('movie_spoken_language', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('spoken_language_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('spoken_language_id')->references('id')->on('spoken_languages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_spoken_language');
        Schema::dropIfExists('spoken_languages');
        Schema::dropIfExists('movie_production_country');
        Schema::dropIfExists('production_countries');
        Schema::dropIfExists('movie_production_company');
        Schema::dropIfExists('production_companies');
        Schema::dropIfExists('movie_genre');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('movies');
    }
};
