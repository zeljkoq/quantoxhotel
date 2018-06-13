<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartyRequest;
use App\Http\Resources\PartyResource;
use App\Models\Party;
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
        $party->name = $request->partyName;
        $party->date = \Carbon\Carbon::createFromTimestamp(strtotime($request->partyDate));

        $party->duration = $request->partyDuration;
        $party->capacity = $request->partyCapacity;
        $party->description = $request->partyDescription;
        $party->tags = $request->partyTags;
        $party->updated_by = $request->user()->id;

        $party->save();

        return new PartyResource($party);
    }

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

    public function update(PartyRequest $request, $party_id)
    {
//        dd();
        $party = Party::where('id', $party_id)->first();
        $party->name = $request->partyName;
        $party->date = \Carbon\Carbon::parse(strtotime($request->partyDate));

        $party->duration = $request->partyDuration;
        $party->capacity = $request->partyCapacity;
        $party->description = $request->partyDescription;
        $party->tags = $request->partyTags;
        $party->updated_by = $request->user()->id;
        $party->update();
        return new PartyResource($party);
    }
}
