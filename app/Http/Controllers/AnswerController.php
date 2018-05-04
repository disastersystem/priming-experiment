<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request) {
        $unique_id = uniqid();
        
        foreach ($request->all() as $answer) {
            $answer['subject'] = $unique_id;

            Answer::create($answer);
        }
    }
}
