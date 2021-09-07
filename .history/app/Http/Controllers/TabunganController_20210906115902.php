<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\M_rekening;
use App\Models\M_transaksi;

class TabunganController extends Controller
{
    //
    public function index(){
        $data=array(
            'formAction' => url('tabungan/simpan'),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.status','=','1')->get(),
            'tabungan' => M_transaksi::join('rekening','rekening.norek','=','transaksi.norek')
                            ->join('nasabah','nasabah.nin','=','rekening.nin')
                            ->where('rekening.status','=','1')
                            ->where('transaksi.jnstransaksi','=','setor')
                            ->orwhere('transaksi.jnstransaksi','=','tarik')
                            ->orderby('waktu','desc')->get()
        );
        return view('admin/tabungan')->with($data);
        //$angka="Rp. 4000.000";
        //echo preg_replace("/[Rp.]/","",$angka);
    }

    public function cari(Request $request){
        //$input = $request->all();
        $norek = $request->norek;
        // /
        $queri = M_rekening::select('nasabah.nin','rekening.norek')->join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first();
        $queri2 = M_transaksi::select( 
            DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
            )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
            ->where('rekening.norek','=',$norek)
            ->orwhere('transaksi.norektujuan','=',$norek)   
            ->first();
        $data = array(
            'norek' => $queri->norek,
            'nin' => $queri->nin,
            'saldo' => ($queri2->setor+$queri2->transfer) - ($queri2->tarik+$queri2->transfer2)
        );
        return response()->json($data);
    }

    public function simpan(Request $request){

        $nominal=preg_replace("/[Rp. ]/", "", $request->nominal);
        $nominal=preg_replace("/[.]/", "", $nominal);
        $nominal=trim($nominal);

        $saldo=preg_replace("/[Rp. ]/", "",$request->saldo);
        $saldo=preg_replace("/[.]/", "", $saldo);
        $saldo=trim($saldo);
        if($request->jenis=='setor'){
            DB::table('transaksi')->insert([
                'norek' => $request->norek,
                'waktu' =>  date('Y-m-d H:i:s'),
                'nominal' => $nominal,
                'sandi' => '01',
                'via' => '101',
                'jnstransaksi' => $request->jenis,
                'norektujuan' => '-',
                'idsubrekening' => '-',
                'keterangan' => '-',
                'iduser' => session()->get('iduser')
            ]);
            return redirect('/tabungan')->with(['success' => 'Berhasil disimpan!']);
        }else{
            if($saldo>$nominal){
                if(5000 < $saldo-$nominal){
                    DB::table('transaksi')->insert([
                        'norek' => $request->norek,
                        'waktu' =>  date('Y-m-d H:i:s'),
                        'nominal' => $nominal,
                        'sandi' => '02',
                        'via' => '101',
                        'jnstransaksi' => $request->jenis,
                        'norektujuan' => '-',
                        'idsubrekening' => '-',
                        'keterangan' => '-',
                        'iduser' => session()->get('iduser')
                    ]);
                    return redirect('/tabungan')->with(['success' => 'Berhasil disimpan!']);
                }else{
                    return redirect('/tabungan')->with(['danger' => 'Maaf, saldo anda tidak cukup!']);
                }
            }else{
                return redirect('/tabungan')->with(['danger' => 'Maaf, saldo anda tidak cukup!']);
            }
        }
       
    }

    public function hapus($id){
        DB::table('transaksi')->where('idtransaksi',$id)->delete();
        return redirect('/tabungan')->with(['success' => 'Transaksi Berhasil Dibatalkan!']);
    }
}
