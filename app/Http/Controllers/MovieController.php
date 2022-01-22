<?php

namespace App\Http\Controllers;


use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_num = User::all()->count();
        $ratings_num = Rating::all()->count();
        $movies_num = Movie::all()->count();

        if( !(Auth::check()) ) {
            $movies = Movie::with('ratings')->paginate(10);
            return view('movies.index', compact('movies', 'users_num', 'ratings_num', 'movies_num'));
        }
        $admin = Auth::user()->is_admin;
        if($admin) {
            $movies = Movie::withTrashed('ratings')->paginate(10);
            return view('movies.index', compact('movies', 'users_num', 'ratings_num', 'movies_num'));
        } else {
            $movies = Movie::with('ratings')->paginate(10);
            return view('movies.index', compact('movies', 'users_num', 'ratings_num', 'movies_num'));
        }
    }

    /**
     * Display a listing of the six best rated films.
     *
     * @return \Illuminate\Http\Response
     */
    public function top()
    {
        $all_movies = Movie::all();
        $movies = collect();

        $users_num = User::all()->count();
        $ratings_num = Rating::all()->count();
        $movies_num = Movie::all()->count();

        foreach($all_movies as $movie) {
            $row = $movie;
            $rating = floor($movie->ratings->avg('rating'));
            $row['rating'] = $rating;
            $movies->push($row);
        }
        $movies = $movies->sortByDesc('rating')->take(6);

        return view('movies.top', compact('movies', 'users_num', 'ratings_num', 'movies_num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Movie $movie)
    {
        $this->authorize('create', $movie);

        return view('movies.create');
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
            'title' => 'required|max:255',
            'director' => 'required|max:128',
            'year' => 'required|integer|min:1870|max:2021',
            'description' => 'max:512',
            'length' => 'required',
            'image' => 'nullable|file|mimes:jpg,png|max:2048',
        ], [
            'title.required' => 'A film cím megadása kötelező',
            'title.max' => 'A film címének hossza max 255 karakter lehet',
            'director.required' => 'A rendező nevének megadása kötelező',
            'director.max' => 'A rendező nevének hossza max 128 karakter lehet',
            'year.required' => 'Az év megadása kötelező',
            'year.min' => 'Az év nem lehet 1870-nél korábbi',
            'year.max' => 'Az év nem lehet 2021-nél későbbi',
            'description.max' => 'A leírás hossza max 512 karakter lehet',
            'length.required' => 'A film hosszának megadása kötelező',
            'image.file' => 'Csak .png és .jpg állományt lehet feltölteni' ,
            'image.mimes' => 'Csak .png és .jpg állományt lehet feltölteni' ,
            'image.max' => 'A feltöltött kép max mérete 2MB lehet',
        ]);
        $data['ratings_enabled'] = false;
        if($request->has('ratings_enabled')) {
            $data['ratings_enabled'] = true;
        }

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->hashName();
            Storage::disk('public')->put('thumbnails/' . $data['image'], $file->get());
        }
        $movie = Movie::create($data);
        $request->session()->flash('movie_created', true);
        return redirect()->route('movies.show', $movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::withTrashed()->find($id);
        $users_num = User::all()->count();
        $ratings_num = Rating::all()->count();
        $movies_num = Movie::all()->count();

        $ratings = Rating::where('movie_id', '=', $id)->orderBy('updated_at')->paginate(10);
        return view('movies.show', compact('movie', 'ratings', 'users_num', 'ratings_num', 'movies_num'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $this->authorize('edit', $movie);

        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'director' => 'required|max:128',
            'year' => 'required|integer|min:1870|max:2021',
            'description' => 'max:512',
            'length' => 'required',
            'image' => 'nullable|file|mimes:jpg,png|max:2048',
        ], [
            'title.required' => 'A film cím megadása kötelező',
            'title.max' => 'A film címének hossza max 255 karakter lehet',
            'director.required' => 'A rendező nevének megadása kötelező',
            'director.max' => 'A rendező nevének hossza max 128 karakter lehet',
            'year.required' => 'Az év megadása kötelező',
            'year.min' => 'Az év nem lehet 1870-nél korábbi',
            'year.max' => 'Az év nem lehet 2021-nél későbbi',
            'description.max' => 'A leírás hossza max 512 karakter lehet',
            'length.required' => 'A film hosszának megadása kötelező',
            'image.file' => 'Csak .png és .jpg állományt lehet feltölteni' ,
            'image.mimes' => 'Csak .png és .jpg állományt lehet feltölteni' ,
            'image.max' => 'A feltöltött kép max mérete 2MB lehet',
        ]);
        $data['ratings_enabled'] = false;
        if($request->has('ratings_enabled')) {
            $data['ratings_enabled'] = true;
        }

        if($request->has('delete_image') && !($request->hasFile('image'))) {
            Storage::disk('public')->delete('thumbnails/' . $movie->image);
            $movie->image = NULL;
        }
        if($request->hasFile('image')) {
            Storage::disk('public')->delete('thumbnails/' . $movie->image);
            $movie->image = NULL;

            $file = $request->file('image');
            $movie->image = $file->hashName();
            Storage::disk('public')->put('thumbnails/' . $movie->image, $file->get());
        }
        $movie->title = $request->input('title');
        $movie->director = $request->input('director');
        $movie->year = $request->input('year');
        $movie->description = $request->input('description');
        $movie->length = $request->input('length');
        $movie->ratings_enabled = $data['ratings_enabled'];

        $movie->update();
        $request->session()->flash('movie_updated', true);
        return redirect()->route('movies.show', $movie);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Movie $movie)
    {
        $movie->delete();

        $request->session()->flash('movie_deleted', true);

        return redirect()->route('movies.index');
    }

    public function restore($id)
    {
        Movie::withTrashed()->find($id)->restore();

        Session::flash('movie_restored', true);

        return redirect()->route('movies.index');
    }
}
