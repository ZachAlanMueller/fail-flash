<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class APIController extends Controller
{
    public function databaseUpdates() {
    	$input = Input::all('post');
    	var_dump($input);
    	die();







    }
}
