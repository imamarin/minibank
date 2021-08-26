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

		$desk = json_decode($request->deskripsi,TRUE);
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
			"nomor_pembayaran"=> $request->invoiceNumber,
		);
		DB::table('tagihan')->where($data)->delete();
	}

}