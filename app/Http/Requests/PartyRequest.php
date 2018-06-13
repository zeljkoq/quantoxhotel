<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('party');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'partyName' => 'required|min:5',
            'partyDate' => 'required',
            'partyDuration' => 'required|numeric|max:24',
            'partyCapacity' => 'required|numeric|min:1',
            'partyDescription' => 'required|min:6',
//            'partyTags' => 'required|min:5',
            'coverImage' => 'file',
        ];
    }
}
