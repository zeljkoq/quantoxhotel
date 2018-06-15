<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\SongResource;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSongRequest;


/**
 * Class SongsController
 * @package App\Http\Controllers
 */
class SongsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('songs.index')->with([]);
    }

    /**
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user($user_id)
    {
        return view('user.index')->with([
            'user' => $user_id,
        ]);
    }

    /**
     * @param StoreSongRequest $request
     * @param Song $song
     * @return SongResource
     */
    public function store(StoreSongRequest $request, Song $song)
    {
        $song->artist = $request->artist;
        $song->track = $request->track;
        $song->link = $request->link;
        $song->duration = $request->duration;
        $song->updated_by = $request->user()->id;

        $song->save();

        return new AdminResource($song);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUserData(Request $request)
    {
        $user_id = $request->user()->id;

        if (isset($user_id)) {
            $user = User::find($user_id);

            if ($user->hasRole('dj')) {
                $songs = Song::orderBy('id', 'desc')->paginate(5);

                return AdminResource::collection($songs);
            }

            $songs = Song::orderBy('id', 'desc')->paginate(5);
            return SongResource::collection($songs);

        }
    }


    /**
     * @param $song_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editIndex($song_id)
    {
        return view('songs.edit')->with([
            'song_id' => $song_id,
        ]);
    }

    /**
     * @param $song_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editData($song_id)
    {
        $song = Song::where('id', $song_id)->first();
        return response()->json([
            'song' => $song
        ]);
    }

    /**
     * @param $song_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($song_id)
    {
        if (isset($song_id)) {
            $user = User::findOrFail(auth()->user()->id);

            $song = Song::find($song_id);

            if ($song) {
                if ($user->hasRole('dj')) {
                    $song->delete();
                    return new AdminResource($song);
                }

                if ($user->hasRole('party')) {
                    if ($song->user_id == $user->id) {
                        $song->delete();
                        return new SongResource($song);
                    }

                }
                return response()->json([
                    'message' => 'You don\'t have permission to delete this song.'
                ]);
            }
            return response()->json([
                'message' => 'Song with ID of ' . $song_id . ' does not exists'
            ]);


        }
    }


    /**
     * @param StoreSongRequest $request
     * @param $song_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreSongRequest $request, $song_id)
    {
        $song = Song::where('id', $song_id)->first();
        $song->artist = $request->artist;
        $song->track = $request->track;
        $song->link = $request->link;
        $song->duration = $request->duration;
        $song->updated_by = $request->user()->id;
        $song->update();
        return new AdminResource($song);
    }
}
