<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class QuestionCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    public function __construct() {
        
        $this->validator = app('validator');
        $this->validateEmptywhen($this->validator);
    }

    public function validateEmptywhen($validator) {
        $validator->extend('empty_when', function($attribute, $value, $parameters, $validator) {
            //dd(array_get($validator->getData(), $parameters[0]));
            return empty(array_get($validator->getData(), $parameters[0])) ? true : empty($value); 
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
            'quest' => 'required|unique:questions,text|',
            'ans.*' => 'required|distinct',
            'group' => 'required_if:group2,""|empty_when:group2'
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'quest.required' => 'Please give a question!',
            'quest.unique' => 'This question already exists.',
            'ans.0.required' => 'Please give the right answer!',
            'ans.*.distinct' => 'Every field should be different.',
            'group.required_if' => 'Please either choose an existing group or add a new one',
            'group.empty_when' => 'Please fill only choose question group or add question group'
        ];
        
        for ( $i=1; $i<4; $i++){
            $messages['ans.' .$i . '.required'] = 'Please give a wrong answer!';
        }
        return $messages;
    }
}
