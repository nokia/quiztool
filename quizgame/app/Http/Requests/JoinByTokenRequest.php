<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\GameModel;
use Auth;

class JoinByTokenRequest extends FormRequest
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
     * Custom validation.
     *
     * @return array
     */

    public function __construct() {
        
        $this->validator = app('validator');
        $this->canJoinGame($this->validator);
    }

    public function canJoinGame($validator) {
        $validator->extend('can_join', function($attribute, $value, $parameters, $validator) {
            //dd(array_get($validator->getData(), $parameters[0]));
            $game = GameModel::where('hash_token', $value)->first();
            return is_null($game->start_time); 
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session_token' => 'required|exists:games,hash_token|can_join'
        ];
    }

    public function messages()
    {
        return [
            'session_token.required'    => 'Please give a token!',
            'session_token.exists'      => 'Game not found!',
            'session_token.can_join'      => 'Game already started!',
        ];
    }
}
