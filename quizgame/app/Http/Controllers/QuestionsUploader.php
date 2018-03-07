<?php

namespace App\Http\Controllers;

use App\Models\QuestionModel;
use App\Models\QuestionGroupModel;
use App\Models\AnswerModel;
use App\User;
use App\Http\Requests\QuestionCreationRequest;
use App\Http\Requests\QuestionEditRequest;
use Illuminate\Http\Request;

class QuestionsUploader extends Controller {
	
	public function create(){
		$question_groups = QuestionGroupModel::all();
		return View('uploadquestion')->with(compact('question_groups'));

}
	public function store(Request $request){
		$jsonFile = $request->file("file");
		$questions = json_decode(file_get_contents($jsonFile->getRealPath()), true);
	
		$questions_array = [];

		foreach($questions as $question){
			$q = \App\Models\QuestionModel::create([
				'text' => $question["text"],
				'group_id' => 76
			]);
			
			$answers[] = new \App\Models\AnswerModel([
				'text' => $question["rightanswer"],
				'is_right' => true
			]);
			
			foreach($question["wronganswers"] as $wAnswer) {
				$answers[] = new \App\Models\AnswerModel([
					'text' => $wAnswer,
					'is_right' => false
				]);
			}
			
			$q->answers()->saveMany($answers);
			$questions_array[]=$q;
		}
		
		return View('uploadquestion')->with(['succesMessage'=>'Sikeres Feltöltés']);
	}		
}