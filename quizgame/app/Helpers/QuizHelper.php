<?php
namespace App\Helpers;

use App\Models\AnswerModel;


class QuizHelper {

	/*const SUCCESS_CLASS = "alert alert-success";
	const FAILURE_CLASS = "alert alert-danger";*/
	//const ANSWER_CHECK_CLASS = "";
	
	public static function isCorrectAnswer( $givenAnswerID ) {
		$answer = AnswerModel::find($givenAnswerID);
		if(is_null($answer)){
			return false;
		} else {
			return $answer->is_right;
		}
	}
}