<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreSongRequest
 * @package App\Http\Requests
 */
class StoreSongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('dj');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artist' => 'required|min:3',
            'track' => 'required|min:3',
            'link' => 'required',
            'duration' => 'required|numeric|max:30'
        ];
    }
}
