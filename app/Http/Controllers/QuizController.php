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
        // cant access if the team have been completed quiz
        $teamId = session('team_id');
        if (DB::table('team_answers')->where('team_id', $teamId)->exists()) {
            return back()->with('error', 'Your team has already completed this quiz!');
        }

        $questions = Question::all();
        $answers = Answer::orderBy('question_id')->orderBy('sort_order')->get()->groupBy('question_id');
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

        DB::beginTransaction();
        
        try {
            foreach ($answers as $answerId) {
                DB::table('team_answers')->insert([
                    'id' => Str::uuid(), 
                    'team_id' => $teamId,
                    'answer_id' => $answerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $correctAnswers = Answer::whereIn('id', $answers) 
            ->where('is_correct', true)->with('question')->get();
            $this->calculatePoint($correctAnswers, $teamId);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Quiz successfully submitted!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to submit quiz!', 'error' => $e->getMessage()], 500);
        }
    }

    function calculatePoint($correctAnswers, $teamId)
    {
        $totalPoints = $correctAnswers->sum(fn($answer) => $answer->question->points);
        Team::where('id', $teamId)->increment('green_points', $totalPoints);
    }
}
