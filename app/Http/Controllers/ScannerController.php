<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScannerController extends Controller
{

	public function index(){
		// return view('nasabah/scanner');
		// return view('nasabah/qrcode');
	}

	public function coba(Request $request){
		echo $request->username;
	}

}