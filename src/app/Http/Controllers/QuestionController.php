<?php

namespace App\Http\Controllers;

use App\Events\NewAnswer;
use App\Events\NewQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{

    public function askQuestion(Request $request)
    {
        $q = $request->get('question');

        $question = Question::create([
            'question' => $q
        ]);

        NewQuestion::broadcast($question);
        return $question;
    }

    public function answerQuestion(Request $request, Question $question)
    {
        NewAnswer::broadcast($request->get('answer'));
        return $request->get('answer');
    }
}
