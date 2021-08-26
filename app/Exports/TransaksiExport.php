<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\M_rekening;
use App\Models\M_nasabah;
use App\Models\M_transaksi;
use App\Models\M_subrekening;

use Illuminate\Support\Facades\DB;

class TransaksiExport implements FromView
{
    public function view(): View
    {
        $tgl1=date('Y-m-d',strtotime($_GET['tglawal']));
        $tgl2=date('Y-m-d',strtotime($_GET['tglakhir']));
        $norek = $_GET['norek'];
        if($norek=="semua"){
            $data = array(
                'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                        DB::raw("(SELECT nsb.nama FROM nasabah as nsb WHERE nsb.nin = nasabah.nin) as penerima"))
                        ->join('rekening','rekening.norek','=','transaksi.norek')
                        ->join('nasabah','nasabah.nin','=','rekening.nin')
                        ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                        ->whereBetween('waktu', [$tgl1, $tgl2])
                        ->orderby('waktu','desc')->get(),
                'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first()
            );
        }else{
            $data = array(
                'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                        ->join('rekening','rekening.norek','=','transaksi.norek')
                        ->join('nasabah','nasabah.nin','=','rekening.nin')
                        ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                        ->where('rekening.norek','=',$norek)
                        ->whereBetween('waktu', [$tgl1, $tgl2])
                        ->orderby('waktu','desc')->get(),
                'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first()
            );
        }

        return view('admin/excellaptransaksi', $data);
    }
}
