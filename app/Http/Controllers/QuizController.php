<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        $answers = Answer::all();
        $title = 'Quiz';
        return view('user.rally.quiz', compact('questions', 'answers', 'title'));
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

    // public function 
}
