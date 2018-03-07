<?php

namespace App\Http\Controllers;

use App\Models\QuestionModel;
use App\Models\QuestionGroupModel;
use App\Models\AnswerModel;
use App\User;
use App\Http\Requests\QuestionCreationRequest;
use App\Http\Requests\QuestionEditRequest;
use Illuminate\Http\Request;

class QuestionsController extends Controller {

	public function addQuestion(QuestionCreationRequest $request){

		//$this->authorize('createQuestion', QuestionModel::class);  <--- probably useless , because in QuestionCreationRequest.php the autorize is already there

		$group = QuestionGroupModel::firstOrCreate([
			'name' => $request->has('group') ? $request->group : $request->group2
			]);

		$question = QuestionModel::create([
			'text' => $request->quest,
			'group_id' => $group->id
			]);
		
		foreach($request->ans as $key => $answer){
			
			$answer = AnswerModel::create([
			'question_id' => $question->id,
			'text' => $answer,
			'is_right' => $key<1 ? '1' : '0'
			]);
		}
		
		return redirect()->route('create');
	}

	public function filterQuestions ( Request $request ){
		$questions = QuestionModel::where('id', 'like', '%'.$request->question_id.'%')
									->where('text', 'like', '%'.$request->question_text.'%')
									->with('answers');
        if($request->has('question_group')){
            $questions->where('group_id', $request->question_group);
        }
		if($request->has('questions')) {
			$questions->whereNotIn('id', $request->questions);
		}

		$summaryView = view()
		->make('shared._game_create', ['questions' => $questions->get()])
		->render();

        if ($request->ajax()) {
            return response()->json([
                "ok" => 1,
                "html" => $summaryView
            ], 200);
        }
	}

	public function create(){
		$question_groups = QuestionGroupModel::all();
		return View('addquestion')->with(compact('question_groups'));
	}

    /*public function show($id)
    {
        //
    }*/

	public function show (Request $request, $qid ){
		$selected = QuestionModel::where('id', $qid)->with('answers');
		$rowToSummary = view()
		->make('shared._selected_question', ['selected' => $selected->first()])
		->render();

		$modalToSummary = view()
		->make('shared._selected_modal', ['selected' => $selected->first()])
		->render();

		if ($request->ajax()) {
            return response()->json([
                "ok"	=> 1,
                "row"	=> $rowToSummary,
                "modal"	=> $modalToSummary
            ], 200);

        }
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($qid)
    {
        $question = QuestionModel::where('id', $qid)->with('answers')->first();
        $default_group = QuestionGroupModel::find($question->group_id)->name;
        $question_groups = QuestionGroupModel::all();
        return View('editquestion')->with(compact('question', 'default_group', 'question_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionEditRequest $request, $qid)
    {
        $this->authorize('createQuestion', QuestionModel::class);

        $group = QuestionGroupModel::firstOrCreate([
            'name' => $request->has('group') ? $request->group : $request->group2,
            ]);

        $question = QuestionModel::find($qid);
        $old_group = $question->group_id;
        $question->text = $request->quest;
        $question->group_id = $group->id;
        $question->save();

        $this->deleteGroupIfEmpty($old_group);

        foreach($request->ans as $key => $anstext){
            $answer = AnswerModel::find($key);
            $answer->text = $anstext;
            $answer->save();
        }

        return redirect()->route('create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($qid)
    {
        $question = QuestionModel::find($qid);
        $answers = AnswerModel::where('question_id', $qid)->get();
        $group_id = $question->group_id;
        $question->delete();

        $this->deleteGroupIfEmpty($group_id);

        foreach ($answers as $ans) {
            $ans->delete();
        }

        return redirect()->route('create');
    }

    protected function deleteGroupIfEmpty( $group_id ) {
    	if(count(QuestionModel::where('group_id', $group_id)->get())<1){
    		$group = QuestionGroupModel::find( $group_id );
            $group->delete();
        }
    }

}