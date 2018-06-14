<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartyRequest;
use App\Http\Resources\PartyResource;
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
    }

    /**
     * @param PartyRequest $request
     * @param Party $party
     * @return PartyResource
     */
    public function store(PartyRequest $request, Party $party)
    {
        $lastParty = Party::orderBy('created_at', 'desc')->first();

        $party->name = $request->partyName;
        $party->date = \Carbon\Carbon::createFromTimestamp(strtotime($request->partyDate));
        $party->duration = $request->partyDuration;
        $party->capacity = $request->partyCapacity;
        $party->description = $request->partyDescription;
        $party->tags = $request->partyTags;
        $party->updated_by = $request->user()->id;
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
        $songs = Song::all()->pluck('duration')->toArray();
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
                        continue;
                    }
                } while ($dur < $partyDuration);
            }
        } else {
            if ($songsDuration < $partyDuration) {
                do {
                    $songsFromLastParty = Playlist::where('party_id', $lastParty->id)->get()->toArray();
                    $song = Song::inRandomOrder()->first();

                    if ($songsFromLastParty !== $newSongs) {
                        array_push($duration, $song->duration);
                        $dur = array_sum($duration);
                        array_push($newSongs, $song->id);

                        continue;
                    }
                } while ($dur < $partyDuration);
            } else {
                do {
                    $songsFromLastParty = Playlist::where('party_id', $lastParty->id)->get()->toArray();
                    $song = Song::inRandomOrder()->first();

                    if ($songsFromLastParty !== $newSongs) {
                        if (!in_array($song->id, $newSongs)) {
                            array_push($duration, $song->duration);
                            $dur = array_sum($duration);
                            array_push($newSongs, $song->id);
                            continue;
                        }
                        continue;
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
//        dd($request->partyDate);
        $party = Party::where('id', $party_id)->first();
        $party->name = $request->partyName;

        $date1 = strtr($request->partyDate, '/', '-');
        $date1 = date('Y-m-d H:i', strtotime($date1));
        $party->date = $date1;
        $party->duration = $request->partyDuration;
        $party->capacity = $request->partyCapacity;
        $party->description = $request->partyDescription;
        $party->tags = $request->partyTags;
        $party->updated_by = $request->user()->id;
        $party->update();
        return new PartyResource($party);
    }


}
