<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use stdClass;
use DB;
use App\Http\Requests;

class AdminController extends Controller
{
    public function updates() {
    	$ret = authCheck();
	    var_dump($ret);
	    die();
	}
}
