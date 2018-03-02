<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request) {
    	$answer = new Answer;

    	$answer->image = $request->image;
        $answer->answer = $request->answer;
        $answer->subject = $request->subject;

        // The created_at and updated_at timestamps will automatically be set when 
        // the save method is called, so there is no need to set them manually.
        return ($answer->save()) ? 'saved' : 'not saved';
    }
}
