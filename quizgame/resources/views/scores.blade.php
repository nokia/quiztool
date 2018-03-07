@extends('layout.master_layout')
@section('title', 'Scores')
@section('content')

<div class="quiz-scores container">
    <div class="header row">
        <div class="col-md-4 text-center">
            <span class="fa-stack fa-lg">
              <i class="fa fa-check-square-o fa-2x"></i>
            </span>
            <span>Correct answer</span>
        </div>
        <div class="col-md-4 text-success text-center">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-check fa-stack-1x"></i>
            </span>
            <span>Your answer is good</span>
        </div>
        <div class="col-md-4 text-danger text-center">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x"></i>
            </span>
            <span>Your answer is bad</span>
        </div>
    </div>
    <div class="body row">
        @forelse($game->questions as $question)
            <div class="question-result">
                <div class="question-text alert {{ QuizHelper::isCorrectAnswer($quiz[$question->id]) ? "alert-success" : "alert-danger"}}">{{ $question->text }}</div>
                <div class="status-indicator">
                    <span class="fa-stack fa-lg text-{{ QuizHelper::isCorrectAnswer($quiz[$question->id]) ? "success" :"danger" }} text-right">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa fa-{{ QuizHelper::isCorrectAnswer($quiz[$question->id]) ? "check" :"times" }} fa-stack-1x"></i>
                    </span>
                </div>
                <ul class="question-result-answers">
                    
                    @foreach($question->answers as $answer)
                        <li class="answer {{ $answer->is_right ? "corr-answ" : ""}}">
                        @if($answer->is_right)
                          <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        @endif
                        {{ $answer->text }}</li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p>No questions to be displayed.</p>
        @endforelse
        
    </div>
    <div class="footer">
        <p class="result-scores"> {{$points}} of {{ $game->questions->count() }} points</p>
        <form action="{{ route('home') }}" method="get" accept-charset="utf-8">
            <input type="submit" class="btn btn-default" value="OK"></input>
        </form>
    </div>
</div>

@stop
