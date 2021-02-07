<?php

namespace App\Http\Controllers;

use App\Events\NewQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{

    public function askQuestion(Request $request)
    {
        $q = $request->get('question');
        NewQuestion::broadcast($q);
    }

    public function answerQuestion(Request $request)
    {

    }
}
