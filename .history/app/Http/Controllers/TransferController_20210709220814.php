<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\M_rekening;
use App\Models\M_transaksi;
use App\Models\M_subrekening;

class TransferController extends Controller
{
    //
    public function index(){
        $data=array(
            'formAction' => url('transfer/simpan'),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.status','=','1')->get(),
            'tabungan' => M_transaksi::select('nasabah.*','transaksi.*','subrekening.subrekening')
                            ->join('rekening','rekening.norek','=','transaksi.norek')
                            ->join('nasabah','nasabah.nin','=','rekening.nin')
                            ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                            ->where('rekening.status','=','1')
                            ->where('transaksi.jnstransaksi','=','transfer')->orderby('waktu','desc')->get()
        );
        return view('admin/transfer')->with($data);
        //$angka="Rp. 4000.000";
        //echo preg_replace("/[Rp.]/","",$angka);
    }

    public function cari(Request $request){
        //$input = $request->all();
        $norek = $request->norek;
        // /
        $queri = M_rekening::select('nasabah.nin','rekening.norek')->join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek);
        $queri2 = M_transaksi::select( 
            DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
            DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
            )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
            ->where('rekening.norek','=',$norek)
            ->orwhere('transaksi.norektujuan','=',$norek);
        
        if($queri->count()>0 AND $queri2->count()>0 ){ 
            $q2=$queri2->first();
            $q=$queri->first();

            $queri3 = DB::table('siswa')->select('siswa.*')
            ->join('rekening','rekening.nin','=','siswa.nin')
            ->where('rekening.norek','=',$norek);
            if($queri3->count()>0){
               
                $q3=$queri3->first();
                $thnmasuk=$q3->thnmasuk;
                $data = array(
                    'norek' => $q->norek,
                    'nin' => $q->nin,
                    'thnmasuk' =>$thnmasuk,
                    'saldo' => ($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2),
                    'sukses' => 1
                );
            }else{
                $data = array(
                    'norek' => $q->norek,
                    'nin' => $q->nin,
                    'thnmasuk' =>"",
                    'saldo' => ($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2),
                    'sukses' => 1
                );
            }
           
        }else{
            $data = array(
                'norek' => "",
                'nin' => "",
                'thnmasuk' =>"",
                'saldo' => "",
                'sukses' => 0
            );
        }
       
         
        return response()->json($data);
    }

    public function cariPembayaran(Request $request){
        
        $queri = M_subrekening::where('norek','=',$request->norek)
                ->where('thnpembayaran','=',$request->thnmasuk);
        if($queri->count()>0){
            $queri = $queri->get();
            echo "<option value=''></option>";
            foreach($queri as $data){
                echo "<option value='".$data->idsubrekening."'>".$data->subrekening."</option>";
            }
        }else{
            echo $request->norek;
        }
    }

    public function cariNominalPembayaran(Request $request){
        
        $queri = DB::table('subrekening')->where('idsubrekening','=',$request->pembayaran)
                ->where('thnpembayaran','=',$request->thnmasuk);
        if($queri->count()>0){
            $q = $queri->first();
            return $q->nominal;
        }else{
            return 0;
        }
    }

    public function simpan(Request $request){

        $nominal=preg_replace("/[Rp. ]/", "", $request->nominal);
        $nominal=preg_replace("/[.]/", "", $nominal);
        $nominal=trim($nominal);

        $saldo=preg_replace("/[Rp. ]/", "",$request->saldo);
        $saldo=preg_replace("/[.]/", "", $saldo);
        $saldo=trim($saldo);

        $nominalpembayaran=preg_replace("/[Rp. ]/", "",$request->nominalpembayaran);
        $nominalpembayaran=preg_replace("/[.]/", "", $nominalpembayaran);
        $nominalpembayaran=trim($nominalpembayaran);

            if($saldo>$nominal){
                if($request->jenis){
                    if($nominalpembayaran <= $nominal){
                        DB::table('transaksi')->insert([
                            'norek' => $request->norek,
                            'waktu' =>  date('Y-m-d H:i:s'),
                            'nominal' => $nominal,
                            'jnstransaksi' => 'transfer',
                            'norektujuan' => $request->tujuan?$request->tujuan:'-',
                            'idsubrekening' => $request->jenis?$request->jenis:'-',
                            'keterangan' => $request->keterangan?$request->keterangan:'-',
                            'iduser' => session()->get('iduser')
                        ]);
                        return redirect('/transfer')->with(['success' => 'Berhasil disimpan!']);
                    }else{
                        return redirect('/transfer')->with(['danger' => 'Maaf, nominal tidak mencukupi minimal pembayaran!']);
                    }
                }else{
                    DB::table('transaksi')->insert([
                        'norek' => $request->norek,
                        'waktu' =>  date('Y-m-d H:i:s'),
                        'nominal' => $nominal,
                        'jnstransaksi' => 'transfer',
                        'norektujuan' => $request->tujuan?$request->tujuan:'-',
                        'idsubrekening' => $request->jenis?$request->jenis:'-',
                        'keterangan' => $request->keterangan?$request->keterangan:'-',
                        'iduser' => session()->get('iduser')
                    ]);

                    return redirect('/transfer')->with(['success' => 'Berhasil disimpan!']);
                }

            }else{
                return redirect('/transfer')->with(['danger' => 'Maaf, saldo anda tidak cukup!']);
            }
       
    }

    public function hapus($id){
        DB::table('transaksi')->where('idtransaksi',$id)->delete();
        return redirect('/transfer')->with(['success' => 'Transaksi Berhasil Dibatalkan!']);
    }
}
