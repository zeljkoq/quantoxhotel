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
            'partyName' => 'required|min:6',
            'partyDate' => 'required|min:6',
            'partyDuration' => 'required|min:6',
            'partyCapacity' => 'required|min:6',
            'partyDescription' => 'required|min:6',
            'partyTags' => 'required|min:6',
        ];
    }
}
