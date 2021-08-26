<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




use App\Models\M_rekening;
use App\Models\M_nasabah;
use App\Models\M_transaksi;
use App\Models\M_subrekening;

use Excel;
use App\Exports\TransaksiExport;

class PrinttabunganController extends Controller
{
    //
    public function index(){
        $data = array(
            'transaksi' => array(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get(),
            'print' => 0,
            'norek' => ''
        );
        return view('admin/bukutabungan')->with($data);
    }

    public function cari(Request $request){
        $data = array(
            'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                    DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                    ->join('rekening','rekening.norek','=','transaksi.norek')
                    ->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                    ->where('rekening.status','=','1')
                    ->where('rekening.norek','=',$request->norek)
                    ->orwhere('transaksi.norektujuan','=',$request->norek)
                    ->orderby('waktu','asc')->get(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get(),
            'print' => 1,
            'norek' => $request->norek
        );
        return view('admin/bukutabungan')->with($data);
    }

    public function cetak(Request $request){
        
        $norek = $request->norek2;
        $data = array(
            'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                    DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                    ->join('rekening','rekening.norek','=','transaksi.norek')
                    ->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                    ->where('rekening.status','=','1')
                    ->where('rekening.norek','=',$request->norek2)
                    ->orwhere('transaksi.norektujuan','=',$request->norek2)
                    ->orderby('waktu','asc')->get(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first(),
            'norek' => $norek,
            'baris' => $request->baris,
            'rec1' => $request->awalrecord,
            'rec2' => $request->akhirrecord
        );

        // return "asdasd";
        return view('admin/printtabungan')->with($data);
    }

    public function excellaptransaksi(){
        $nama_file = 'laporan_transaksi_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new TransaksiExport, $nama_file);
    }

}
