<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

	public function notif(Request $request){
		// $request=json_decode($req,true);
		// $data = array(						
		// 	'code' => $request['code'],
		// 	'message' => $request['message'],
		// 	'type' => $request['type'],
		// 	'id'   => $request['id'],
		// 	'number'   => $request['number'],
		// 	'amount'   => $request['amount'],
		// 	'remainingamount'   => $request['remainingAmount'],
		// 	'va'   => $request['va'],
		// 	'date'   => $request['date'],
		// 	'bankcode'   => $request['bankCode'],
		// 	'bankname'   => $request['bankName'],
		// 	'ref'   => $request['ref'],
		// 	'channel'   => $request['channel'],
		// 	'name'   => $request['name'],
		// 	'phone'   => $request['phone'],
		// 	'email'   => $request['email'],
		// 	'timenotif'   => date('Y-m-d H =>i =>s'),
		// 	'address'   => $request['address'],
		// 	// 'coba' => $request
		// );

		$data = array(						
			'code' => $request->code,
			'message' => $request->message,
			'type' => $request->type,
			'number'   => $request->number,
			'amount'   => $request->amount,
			'remainingAmount'   => $request->remainingAmount,
			'va'   => $request->va,
			'date'   => $request->date,
			'bankCode'   => $request->bankCode,
			'bankName'   => $request->bankName,
			'ref'   => $request->ref,
			'channel'   => $request->channel,
			'name'   => $request->name,
			'phone'   => $request->phone,
			'email'   => $request->email,
			'timenotif'   => date('Y-m-d H:i:s'),
			'address'   => $request->address,
		);

		// $data = array(
		// 	"code" => "00",
		// 	"message" => "Transaksi berhasil",
		// 	"type" => "payment",
		// 	"id" => 109021,
		// 	"number" => 8087,
		// 	"amount" => 100000,
		// 	"remainingAmount" => 0,
		// 	"va" => "88081234567",
		// 	"date" => "2021-11-22",
		// 	"bankCode" => "BSM",
		// 	"bankName" => "Bank Syariah Mandiri",
		// 	"ref" => "20211221304320001",
		// 	"channel" => "ATM",
		// 	"name" => "Alfiyah",
		// 	"phone" => "asds",
		// 	"email" => "alfiyah@sebuahdomain.com",
		// 	"address" => "sdsad",
		// 	'timenotif'   => date('Y-m-d H:i:s'),
		// 	'coba' => $request->id
		// );
		// return $request->type;

		//return print_r($data);
		DB::table('notif')->insert($data);	
	}

}