<?php

namespace App\Http\Controllers;


use App\Http\Resources\AdminResource;
use App\Http\Resources\SongResource;
use App\Song;
use App\Http\Resources\Songs;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSongRequest;
use Illuminate\Support\Facades\Auth;


class SongsController extends Controller
{

    public function index()
    {
        return view('songs.index');
    }

    public function store(StoreSongRequest $request, Song $song)
    {

        $song->artist = $request->artist;
        $song->track = $request->track;
        $song->link = $request->link;
        $song->user_id = $request->user_id;
        $song->save();

        return response()->json([
            'song' => $song
        ]);

    }

    public function getUserData($user_id)
    {

        if (Auth::user()) {
            $songs = Song::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
            return SongResource::collection($songs);
        } else {
            $songs = Song::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            return SongResource::collection($songs);
        }

    }

    public function editIndex($song_id)
    {
        return view('songs.edit')->with([
            'song_id' => $song_id,
        ]);
    }

    public function editData($song_id)
    {
        $song = Song::where('id', $song_id)->first();
        return response()->json([
            'song' => $song
        ]);

    }

    public function delete($song_id)
    {
        Song::destroy($song_id);

        return response()->json([
            'song' => $song_id
        ]);
    }

    public function update(StoreSongRequest $request, $song_id)
    {
        $song = Song::findOrFail($song_id);

        $song->artist = $request->artist;
        $song->track = $request->track;
        $song->link = $request->link;

        $song->update();

        return response()->json([
            'song' => $song
        ]);
    }
}
