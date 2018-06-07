<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $roles = auth()->user()->roles()->get()->pluck('name')->toArray();
        $routesCollection = [
            'songs',
            'party',
        ];
        $routes = array_intersect_key($routesCollection, $roles);
        return 13;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
