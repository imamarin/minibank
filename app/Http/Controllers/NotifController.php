<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{

	public function notif(Request $request){
		DB::table('notif')->insert($data);	
	}

}