<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class langController extends Controller
{
    public function index($lang) {
    	\Session::put('locale', $lang);
    	return redirect()->back();
	}
}
