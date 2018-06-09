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
//        $roles = auth()->user()->roles()->get();
//
//        foreach ($roles as $role)
//        {
//        	if($roles->contains('name', $role->name))
//	        {
//	        	return true;
//	        }
//        }
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
