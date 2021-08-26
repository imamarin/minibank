<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_rekening;
use App\Models\M_nasabah;
use App\Models\M_transaksi;
use App\Models\M_subrekening;

class HomeController extends Controller
{


    public function index(){
        $data = array(
            'nasabah' => M_nasabah::count(),
            'nasabahaktif' => M_nasabah::join('rekening','rekening.nin','=','nasabah.nin')->where('rekening.status','=','1')->count(),
            'addnasabahaktif' => M_nasabah::join('users','users.iduser','=','nasabah.iduser')
                            ->join('rekening','rekening.nin','=','nasabah.nin')->where('rekening.status','=','1')
                            ->where(DB::raw("DATE_FORMAT(users.created_at,'%Y-%m-%d')"),'=',date('Y-m-d'))->count(),
            'addnasabah' => M_nasabah::join('users','users.iduser','=','nasabah.iduser')->where(DB::raw("DATE_FORMAT(users.created_at,'%Y-%m-%d')"),'=',date('Y-m-d'))->count(),
            'tabungan' => M_transaksi::select(
                        DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                        DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
                       )->first(),
            'addtabungan' => M_transaksi::select(
                        DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                       )->where(DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m-%d')"),'=',date('Y-m-d'))->first(),
            'transaksi' => M_transaksi::where(DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m-%d')"),'=',date('Y-m-d'))->count(),

        );
        
        //echo date('Y-m-d');
        return view('admin/home')->with($data);
    }

    public function setoran(Request $request){
        $setor = M_transaksi::select('transaksi.jnstransaksi',DB::raw("DATE_FORMAT(transaksi.waktu,'%e') as tgl"),DB::raw("COUNT(transaksi.nominal) as nom"))
                // ->where('transaksi.jnstransaksi','=','setor')
                ->where(DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m')"),'=',date('Y-m'))
                ->groupBy('transaksi.jnstransaksi',DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m-%d')"))->get();
        
        $arr = array();
        foreach($setor as $row){
            $arr[$row->jnstransaksi."-".$row->tgl] = $row->nom;
        }
        echo json_encode($arr);
    }

    public function tarik(){
        $tarik = M_transaksi::where('transaksi.jnstransaksi','=','tarik')->groupBy(DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m-%d')"))->get();
    }
}
