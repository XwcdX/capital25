<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $title = 'quizRules';
        return view('user.rally.quizRules', compact('title'));
    }

    public function showQuiz()
    {
        $title = 'quiz';
        return view('user.rally.quiz', compact('title'));
    }
}
