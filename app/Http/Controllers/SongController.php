<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Song;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use App\Events\NewSongCreatedEvent;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $songs = app(Pipeline::class)
            ->send(Song::query())
            ->through([
                \App\Http\QueryFilters\Sort::class,
                \App\Http\QueryFilters\RSearch::class,
            ])
            ->thenReturn()
            ->paginate(10);

        return view('songs.index', compact('songs'));
    }

    public function create()
    {
        $genres = Genre::all();

        return view('songs.create', compact('genres'));
    }

    public function store()
    {
        $data = \request()->validate([
            'name' => 'required|min:3|max:120',
            'genre_id' => 'required'
        ]);

        $song = Auth::user()->songs()->create($data);

        event(new NewSongCreatedEvent(Auth::user(), $song));

        return redirect('songs');
    }

    public function show(Song $song)
    {
        return view('songs.show', compact('song'));
    }

    public function edit(Song $song)
    {
        $genres = Genre::all();

        return view('songs.edit', compact('song', 'genres'));
    }

    public function update(Song $song)
    {
        $data = \request()->validate([
            'name' => 'required|min:3|max:120',
            'genre_id' => 'required'
        ]);

        $song->update($data);

        return redirect('songs');
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect('songs');
    }
}

