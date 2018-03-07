<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerModel extends Model
{
	protected $table = "answers";

	public $timestamps = true;

    //
    protected $fillable = [
        'question_id', 'text', 'is_right'
    ];

    protected $casts = [
    	'is_right' => 'boolean'
    ];

    public function question(){
    	return $this->belongsTo('App\Models\QuestionModel');
    }
}
