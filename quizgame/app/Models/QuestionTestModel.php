<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTestModel extends Model
{
    public $table = "test_groups";

    public $timestamps = true;

	protected $fillable = [
		'name'
	];

	public function questions(){
    	return $this->hasMany('App\Models\QuestionModel', 'test_id');
    }
    
}
