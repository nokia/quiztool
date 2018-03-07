<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class GameCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session_name' => 'required|unique:games,session_name',
            'questions' => 'required',
        ];
    }

    public function messages()
    {
        //$messages = 
        return [
            'session_name.required' => 'Please give a name!',
            'session_name.unique' => 'A game with this name already exists.',
            'questions.required' => 'At least one question should be in the list.',
        ];

        //return $messages;
    }
}
