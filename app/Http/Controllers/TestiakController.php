<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestiakController extends Controller
{

	public function index(){
		return view('testiak');
	}

	public function coba(Request $request){
		echo $request->username;
	}

}