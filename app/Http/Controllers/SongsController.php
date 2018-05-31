<?php

namespace App\Http\Controllers;


use App\Http\Resources\AdminResource;
use App\Http\Resources\SongResource;
use App\Http\Resources\UserResource;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSongRequest;
use Illuminate\Support\Facades\Auth;


class SongsController extends Controller
{

    public function index()
    {
        return view('songs.index')->with([
            'currentUser' => auth()->user(),
        ]);
    }

    public function user($user_id)
    {
        return view('user.index')->with([
            'user' => $user_id,
        ]);
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

    public function getUserData(Request $request)
    {

        $user = User::findOrFail(Auth()->guard('api')->user()->id);

        if ($user->hasRole('admin')) {
            $songs = Song::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
            return AdminResource::collection($songs);
        } elseif ($user->hasRole('user')) {
            $songs = Song::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
            return UserResource::collection($songs);
        } else {
            $songs = Song::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
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
