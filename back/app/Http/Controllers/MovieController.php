<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller{
    function peliculas(){
        $movies =Movie::where('activo', 1)->where('proximo', 0)->get();
        $movieRes = [];
        foreach ($movies as $movie){
            $movieRes[] = json_decode($movie->json);
        }
        return $movieRes;
    }
    function proximos(){
        $movies =Movie::where('activo', 1)->where('proximo', 1)->get();
        $movieRes = [];
        foreach ($movies as $movie){
            $movieRes[] = json_decode($movie->json);
        }
        return $movieRes;
    }
    public function index(){
        return Movie::orderBy('id', 'desc')->get();
    }
    public function store(Request $request){
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->json = $request->json;
        $movie->proximo = $request->proximo;
        $movie->activo = $request->activo;
        $movie->save();
        return $movie;
    }
    public function update(Request $request, $id){
        $movie = Movie::find($id);
        $movie->title = $request->title;
        $movie->json = $request->json;
        $movie->proximo = $request->proximo;
        $movie->activo = $request->activo;
        $movie->save();
        return $movie;
    }
    public function destroy($id){
        $movie = Movie::find($id);
        $movie->delete();
        return $movie;
    }
}
