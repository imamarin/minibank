<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_rekening;
use App\Models\M_nasabah;

class ReqinvoiceController extends Controller
{

	public function index(){
        $data = array(
            'token' => app('App\Http\Controllers\TokenController')->get(),
			'tagihan' => DB::table('tagihan')->get()
        );
		return view('admin/reqinvoice')->with($data);
	}

	public function add(){
		$data = array(
			'token' => app('App\Http\Controllers\TokenController')->get(),
			'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get(),
			'nama' => "",
			'email' => "",
			'nohp' => "",
			'alamat' => "",
			'norek' => null,
			'waktuawal' => date('Y-m-d H:i:s'),
			'waktuakhir' => date('Y-m-d H:i:s'),
			"tgl" => "",
			'detail' => array(),
			"onclick" => "simpanTagihan()",
			"id" => ""
		);
		return view('admin/addtagihan')->with($data);
	}

	public function edit($id){
		$where =  array(
			'tagihan.nomor_pembayaran' => $id	
		);
		$queri = DB::table('tagihan')->join('rekening','rekening.norek','=','tagihan.nomor_induk')
		->join('nasabah','nasabah.nin','=','rekening.nin')
		->where($where);
		if($queri->count() > 0){
			$q = $queri->first();
			$data = array(
				'token' => app('App\Http\Controllers\TokenController')->get(),
				'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get(),
				'nama' => $q->nama,
				'email' => $q->email,
				'nohp' => $q->nohp,
				'alamat' => $q->alamat,
				'norek' => $q->norek,
				'waktuawal' => $q->waktu_berlaku,
				'waktuakhir' => $q->waktu_berakhir,
				"tgl" => $q->tanggal,
				'detail' => DB::table('detil_tagihan')->where('id_record_tagihan','=',$q->id_record_tagihan)->get(),
				"onclick" => "updateTagihan()",
				"id" => $id
			);
		}else{
			$data = array(
				'token' => app('App\Http\Controllers\TokenController')->get(),
				'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get(),
				'nama' => "",
				'email' => "",
				'nohp' => "",
				'alamat' => "",
				'norek' => null,
				'waktuawal' => date('Y-m-d H:i:s'),
				'waktuakhir' => date('Y-m-d H:i:s'),
				"tgl" => "",
				'detail' => array(),
				"onclick" => "updateTagihan()",
				"id" => $id
			);
		}
		
		return view('admin/addtagihan')->with($data);
	}

	public function input(Request $request){
		DB::table('tagihan')->insert([
			"id_record_tagihan"=> $request->id_record_tagihan,
            "nomor_pembayaran"=> $request->nomor_pembayaran,
            "nama"=> $request->nama,
			"is_tagihan_aktif"=> 1,
			"urutan_antrian"=> 0,
			"tanggal"=>$request->waktu,
			"waktu_berlaku"=>$request->waktuaktif,
			"waktu_berakhir"=>$request->waktuakhir,
			"total_nilai_tagihan"=> $request->total_nilai_tagihan,
			"nomor_induk"=> $request->nomor_induk,
			"pembayaran_atau_voucher"=> "PEMBAYARAN",
		]);

		// $desk = json_decode($request->deskripsi,TRUE);
		// foreach ($desk as $key => $value) {

		// 	# code..
		// 	DB::table('detil_tagihan')->insert([
		// 		"id_record_detil_tagihan"=> $request->id_record_tagihan.''.date('YmdHis').$key,
		// 		"id_record_tagihan"=> $request->id_record_tagihan,
		// 		"urutan_detil_tagihan"=> 0,
		// 		"kode_jenis_biaya"=> $value['description'],
		// 		"label_jenis_biaya"=> $value['description'],
		// 		"label_jenis_biaya_panjang"=> $value['description'],
		// 		"qty"=> $value['qty'],
		// 		"nilai_tagihan"=> $value['amount'],
		// 	]);

		// }

	}

	public function update(Request $request){
		echo $request->nomor_pembayaran;
		DB::table('tagihan')->where('nomor_pembayaran',$request->nomor_pembayaran)->update([
			"id_record_tagihan"=> $request->id_record_tagihan,
            "nomor_pembayaran"=> $request->nomor_pembayaran,
            "nama"=> $request->nama,
			"is_tagihan_aktif"=> 1,
			"urutan_antrian"=> 0,
			"tanggal"=>$request->waktu,
			"waktu_berlaku"=>$request->waktuaktif,
			"waktu_berakhir"=>$request->waktuakhir,
			"total_nilai_tagihan"=> $request->total_nilai_tagihan,
			"nomor_induk"=> $request->nomor_induk,
			"pembayaran_atau_voucher"=> "PEMBAYARAN",
		]);

		$desk = json_decode($request->deskripsi,TRUE);
		DB::table('detil_tagihan')->delete();
		foreach ($desk as $key => $value) {

			# code..
			DB::table('detil_tagihan')->insert([
				"id_record_detil_tagihan"=> $request->id_record_tagihan.''.date('YmdHis').$key,
				"id_record_tagihan"=> $request->id_record_tagihan,
				"urutan_detil_tagihan"=> 0,
				"kode_jenis_biaya"=> $value['description'],
				"label_jenis_biaya"=> $value['description'],
				"label_jenis_biaya_panjang"=> $value['description'],
				"qty"=> $value['qty'],
				"nilai_tagihan"=> $value['amount'],
			]);

		}
	}



	public function batal(Request $request){
		$data = array(
			"nomor_induk"=> $request->va,
			"id_record_tagihan"=> $request->invoiceNumber,
		);
		DB::table('tagihan')->where($data)->delete();
	}

	public function inquiry(){

	}

	public function test_curl(){
		$query = DB::table('nasabah')->join('rekening','rekening.nin','=','nasabah.nin')->get();
		$data=array();
		foreach ($query as $key => $value) {
			# code...
			$data[$key] = array(
				"va"=> $value->norek,
				"date"=> date('Y-m-d'),
				"amount"=> 0,
				"name"=> $value->nama,
				"email"=> "-",
				"address"=> $value->alamat,
				"openPayment"=>true,
				"sequenceNumber" => $key+1,
				"items"=>array(array("description"=>"Tabungan","unitPrice"=>0,"qty"=>0,"amount"=>0)),
				"attributes"=>array()
			);
		}

		echo count($data)."<br>";
		foreach ($data as $key => $val) {
			# code...
			$payload = json_encode($val);
			print_r($payload);
		}
		
		// $str = json_decode(file_get_contents('https://minibank.smk-ypc.sch.id/nasabah.json'),true);
		// foreach ($str as $key => $value) {
		// 	# code...
		// 	echo $value;
		// }

		// // $data = array(array(
		// // 	"va"=> "201904337",
		// // 	"date"=> "2021-09-07",
		// // 	"amount"=> 0,
		// // 	"name"=> "Yaspi Intan Sari",
		// // 	"email"=> "-",
		// // 	"address"=> "Kp. Kalapasewu 4 3 Kp. Kalapasewu Mangunreja Kec. Mangunreja",
		// // 	"openPayment"=>true,
		// // 	"items"=>array(array("description"=>"Tabungan","unitPrice"=>0,"qty"=>0,"amount"=>0)),
		// // 	"attributes"=>array()
		// // 	// 'va' => '22331144',
		// // 	// 'invoiceNumber' => '313108486500124380',
		// // 	// 'amount' => 0
		// // 	),
		// // 	array(
		// // 		"va"=> "201904338",
		// // 		"date"=> "2021-09-07",
		// // 		"amount"=> 0,
		// // 		"name"=> "Winda Sulistia",
		// // 		"email"=> "-",
		// // 		"address"=> "Jl. Pasirjaya Rt.22 Rw.06    Tanjungjaya Kec. Tanjungjaya",
		// // 		"openPayment"=>true,
		// // 		"items"=>array(array("description"=>"Tabungan","unitPrice"=>0,"qty"=>0,"amount"=>0)),
		// // 		"attributes"=>array()
		// // 	)
		// // );
		// foreach ($data as $key => $val) {
		// 	# code...
		// 	$payload = json_encode($val);
	
		// 	$ch = curl_init(); 
	
		// 	// set url 
		// 	curl_setopt($ch, CURLOPT_URL, "https://billing-bpi.maja.id/api/v2/register");
		// 	// curl_setopt($ch, CURLOPT_URL, "https://billing-bpi.maja.id/api/v2/inquiry");
		
		// 	// return the transfer as a string 
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		// 	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		// 	curl_setopt($ch, CURLOPT_POST, true);
		// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	
		// 	// Set HTTP Header for POST request
		// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 		'Content-Type: application/json',
		// 		'Content-Length: '. strlen($payload),
		// 		'Authorization: Bearer '.app('App\Http\Controllers\TokenController')->get()
		// 		)
		// 	);
		// 	// $output contains the output string 
		// 	$output = curl_exec($ch); 
		
		// 	// tutup curl 
		// 	curl_close($ch);      
		
		// 	// menampilkan hasil curl
		// 	echo "<pre>";
		// 	echo $output;
		// 	echo "</pre>";
		// 	print_r($payload);
		// }
		 
	}

}