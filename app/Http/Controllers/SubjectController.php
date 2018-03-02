<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request) {
    	return uniqid('', true);
    }
}
