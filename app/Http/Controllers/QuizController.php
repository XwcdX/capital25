<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        $answers = Answer::all()->groupBy('question_id');
        $storedAnswers = session()->get('storedAnswers', []);
        $title = 'Quiz';

        return view('user.rally.quiz', compact('questions', 'answers', 'title', 'storedAnswers'));
    }

    public function startQuiz()
    {
        if (!session()->has('quiz_end_time')) {
            session(['quiz_end_time' => Carbon::now()->addMinutes(30)]);
        }
    
        return response()->json([
            'quiz_end_time' => session('quiz_end_time')->toIso8601String(),
        ]);
    }

    // save temp answers
    public function saveAnswer(Request $r)
    {
        $questionId = $r->input('question_id');
        $answerId = $r->input('answer_id');

        $storedAnswers = session('storedAnswers', []);

        $storedAnswers[$questionId] = $answerId;
        session(['storedAnswers' => $storedAnswers]);

        return response()->json(['success' => true, 'storedAnswers' => $storedAnswers]);
    }

    public function submitQuiz(Request $r)
    {
        $teamId = session()->get('team_id');
        $answers = $r->input('answers');
        
        $correctAnswers = Answer::whereIn('id', $answers) 
        ->where('is_correct', true)->with('question')->get(); 

        // insert the answer and the tea
        $team = Team::findOrFail($teamId);
        $teamAnswers = [];
    
        foreach ($answers as $answerId) {
            $teamAnswers[$answerId] = ['team_id' => $teamId,];
        }
    
        foreach ($answers as $answerId) {
            DB::table('team_answers')->insert([
                'id' => Str::uuid(), 
                'team_id' => $teamId,
                'answer_id' => $answerId,
            ]);
        }

        //calculate the total points (based on correct answers)
        $this->calculatePoint($correctAnswers, $teamId);
        
        return response()->json(['success' => true, 'message' => 'Quiz is successfully submitted!']);
    }

    function calculatePoint($correctAnswers, $teamId)
    {
        $team = Team::findOrFail($teamId);
        $totalPoints = $correctAnswers->sum(fn($answer) => $answer->question->point); 
        $team->increment('green_points', $totalPoints); 
    }
}
