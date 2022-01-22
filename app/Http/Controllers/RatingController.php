<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|in:1,2,3,4,5'
        ], [
            'rating.required' => 'Kötelező megadni egy értékelést!'
        ]);
        $id = $request->input('id');
        $ratings = Rating::where('user_id', '=', Auth::id())->where('movie_id', '=', $id);
        if($ratings->count() > 0) {
            $ratings->update(['rating' => $request->input('rating')]);
        } else {
            $data['user_id'] = Auth::id();
            $data['movie_id'] = $id;
            $data['comment'] = $request->input('comment');
            $new_rating = Rating::create($data);
        }
        $request->session()->flash('rating_created', true);
        return redirect()->route('movies.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Movie $movie)
    {
        $id = $request->input('id');
        Rating::where('movie_id', $id)->delete();

        $request->session()->flash('ratings_deleted', true);

        return redirect()->route('movies.show', $id);
    }
}
