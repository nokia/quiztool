<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
	public $table = "questions";

	public $timestamps = true;
    //
    protected $fillable = [
        'text', 'group_id'
    ];

    // Relations
    public function answers(){
    	return $this->hasMany('App\Models\AnswerModel', 'question_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function games(){
        return $this->belongsToMany('App\Models\GameModel', 'game_questions', 'question_id', 'game_id');
    }

    public function group(){
        return $this->belongsTo('App\Models\QuestionGroupModel');
    }
}
