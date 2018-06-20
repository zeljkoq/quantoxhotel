<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PartyRequest
 * @package App\Http\Requests
 */
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
            'partyDate' => 'required|after_or_equal:today',
            'partyDuration' => 'required|numeric|max:24|min:1',
            'partyCapacity' => 'required|numeric|min:1',
            'partyDescription' => 'required|min:6',
            'partyTags' => 'required',
            'coverImage' => 'file',
        ];
    }
}
