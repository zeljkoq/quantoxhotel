<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartyRequest;
use App\Http\Resources\PartyResource;
use App\Http\Resources\RegularPartyResource;
use App\Models\JoinedParties;
use App\Models\Party;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * Class PartyController
 * @package App\Http\Controllers
 */
class PartyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('organization.index')->with([
            'currentUser' => auth()->user(),
        ]);
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

            if ($user->hasRole('party')) {
                $songs = Party::orderBy('id', 'desc')->paginate(5);
                return PartyResource::collection($songs);
            }
        }
        $songs = Party::orderBy('id', 'desc')->get();
        return RegularPartyResource::collection($songs);
    }

    /**
     * @param PartyRequest $request
     * @param Party $party
     * @return PartyResource
     */
    public function store(PartyRequest $request, Party $party)
    {
        $songs = Song::all()->pluck('duration')->toArray();
        if (array_sum($songs) > 0) {
            $lastParty = Party::orderBy('created_at', 'desc')->first();

            $party->name = $request->partyName;
            $party->date = date('Y-m-d H:i:s', strtotime($request->partyDate));
            $party->duration = $request->partyDuration;
            $party->capacity = $request->partyCapacity;
            $party->description = $request->partyDescription;
            $party->tags = $request->partyTags;
            $party->updated_by = $request->user()->id;
            $party->start = 0;
            if ($request->hasFile('coverImage')) {
                $filenameExt = $request->file('coverImage')->getClientOriginalName();
                $filename = pathinfo($filenameExt, PATHINFO_FILENAME);
                $extension = $request->file('coverImage')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $path = $request->file('coverImage')->storeAs('public/cover_images', $fileNameToStore);
            } else {
                $fileNameToStore = 'no-image.png';
            }
            $party->cover_image = $fileNameToStore;
            $party->save();

            $partyDuration = $party->duration * 60;

            $songsDuration = array_sum($songs);

            $newSongs = [];
            $duration = [];

            if (!$lastParty) {
                if ($songsDuration < $partyDuration) {
                    $sum = $songsDuration + $partyDuration;
                    do {
                        $song = Song::inRandomOrder()->first();
                        array_push($newSongs, $song->id);
                        $songsDuration += $song->duration;
                    } while ($songsDuration < $sum);
                } else {
                    do {
                        $song = Song::inRandomOrder()->first();

                        if (!in_array($song->id, $newSongs)) {
                            array_push($duration, $song->duration);
                            $dur = array_sum($duration);
                            array_push($newSongs, $song->id);
//                            continue;
                        }
                    } while ($dur < $partyDuration);
                }
            } else {
                if ($songsDuration < $partyDuration) {
                    do {
                        $songsFromLastParty = Playlist::where('party_id', $lastParty->id)->pluck('song_id')->toArray();

                        $dur = array_sum($duration);
                        if ($songsFromLastParty !== $newSongs) {
                            $song = Song::inRandomOrder()->first();
                            array_push($duration, $song->duration);
                            array_push($newSongs, $song->id);

                            continue;
                        }
                    } while ($dur < $partyDuration);
                } else {
                    do {
                        $songsFromLastParty = Playlist::where('party_id', $lastParty->id)->pluck('song_id')->toArray();
                        $song = Song::inRandomOrder()->first();


                        if ($songsFromLastParty !== $newSongs) {
                            if (!in_array($song->id, $newSongs)) {
                                array_push($duration, $song->duration);
                                $dur = array_sum($duration);
                                array_push($newSongs, $song->id);
                                continue;
                            }
                        }
                    } while ($dur < $partyDuration);
                }
            }

            $max = count($newSongs);

            for ($i = 0; $i < $max; $i++) {
                $playlist = new Playlist();
                $playlist->song_id = $newSongs[$i];
                $playlist->party_id = $party->id;
                $playlist->save();
            }

            return new PartyResource($party);
        }

        return response()->json([
            'message' => 'Add some songs first..',
        ]);
    }

    /**
     * @param $party_id
     * @return PartyResource|\Illuminate\Http\JsonResponse
     */
    public function delete($party_id)
    {
        if (isset($party_id)) {
            $user = User::findOrFail(auth()->user()->id);

            $party = Party::find($party_id);

            if ($party) {
                if ($user->hasRole('party')) {
                    $party->delete();
                    return new PartyResource($party);
                }
                return response()->json([
                    'message' => 'You don\'t have permission to delete this song.'
                ]);
            }
            return response()->json([
                'message' => 'Party with ID of ' . $party_id . ' does not exists'
            ]);

        }
    }

    /**
     * @param PartyRequest $request
     * @param $party_id
     * @return PartyResource
     */
    public function update(PartyRequest $request, $party_id)
    {
        $party = Party::where('id', $party_id)->first();
        $party->name = $request->partyName;


        $date1 = strtr($request->partyDate, '/', '-');
        $date1 = date('Y-m-d H:i:s', strtotime($date1));
        $party->date = $date1;
        $party->duration = $request->partyDuration;
        $party->capacity = $request->partyCapacity;
        $party->description = $request->partyDescription;
        $party->tags = $request->partyTags;
        $party->updated_by = $request->user()->id;
        $party->update();
        return new PartyResource($party);
    }

    /**
     * @param Playlist $playlist
     * @param $party_id
     * @return PartyResource|\Illuminate\Http\JsonResponse
     */
    public function start(Playlist $playlist, $party_id)
    {
        $qband = User::where('email', 'qband@local.loc')->first();
        if (isset($party_id)) {
            $party = Party::where('id', $party_id)->first();
            date_default_timezone_set('Europe/Belgrade');

            if (date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime($party->date))) {
                $checkPlaylist = $playlist->where('party_id', $party_id)->where('user_id', null)->get();
                if (count($checkPlaylist) > 0) {
                    $playlist->where('user_id', null)->update(['user_id' => $qband->id]);
                    $party->start = 1;
                    $party->update();
                    return new PartyResource($party);
                }
                $party->start = 1;
                $party->update();
                return new PartyResource($party);
            }
            return response()->json([
                'message' => 'Cannot start party before it\'s time.',
            ]);
        }
        return response()->json([
            'message' => 'Party does not exist',
        ]);
    }

    /**
     * @param $party_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function join($party_id)
    {
        $playlist = new Playlist();

        $joined = JoinedParties::where('user_id', auth()->user()->id)->where('party_id', $party_id)->first();

        if ($joined == null) {
            $party = Party::where('id', $party_id)->first();
            $partyCapacity = JoinedParties::where('party_id', $party_id)->pluck('user_id')->toArray();
            $capacity = count($partyCapacity);

            $playlistCapacity = Playlist::where('party_id', $party_id)->where('user_id', null)->get();
            if ($party->capacity > $capacity) {
                if (count($playlistCapacity) > 0) {
                    // Party not full, join
                    JoinedParties::create(['user_id' => auth()->user()->id, 'party_id' => $party_id]);

                    do {
                        $stop = false;
                        $prevSongs = Playlist::where('party_id', '!=', $party_id)
                            ->where('user_id', auth()->user()->id)->pluck('song_id')->toArray();
                        array_unique($prevSongs);
                        $playlistId = Playlist::inRandomOrder()->where('user_id', null)->pluck('id')->first();
                        $newSong = Playlist::where('id', $playlistId)->first();
                        if (!in_array($newSong->song_id, $prevSongs)) {
                            $playlist->where('song_id', $newSong->song_id)
                                ->where('id', $playlistId)->update(['user_id' => auth()->user()->id]);
                            $stop = true;
                        }
                    } while ($stop == false);
                    return response()->json([
                        'error' => 0,
                        'message' => 'Joined!'
                    ]);
                }
                return response()->json([
                    'error' => 1,
                    'message' => 'You cannot join, party is full.'
                ]);

            }
            return response()->json([
                'error' => 1,
                'message' => 'You cannot join, party is full!'
            ]);
        }
        return response()->json([
            'error' => 1,
            'message' => 'You already joined this party!',
        ]);
    }

    /**
     * @param $arr
     * @return bool
     */
    public function isHomogenous($arr)
    {
        $firstValue = current($arr);
        foreach ($arr as $val) {
            if ($firstValue !== $val) {
                return false;
            }
        }
        return true;
    }
}
