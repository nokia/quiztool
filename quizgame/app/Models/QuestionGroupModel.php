<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionGroupModel extends Model
{
    public $table = "question_groups";

    public $timestamps = true;

	protected $fillable = [
		'name'
	];

	public function questions(){
    	return $this->hasMany('App\Models\QuestionModel', 'group_id');
    }
    
    public function parent(){
    	return $this->hasMany('App\Models\QuestionGroupModel', 'parent_id');
    }
}
