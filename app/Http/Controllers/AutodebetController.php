<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_rekening;
use App\Models\M_nasabah;
use App\Models\M_transaksi;
use App\Models\M_subrekening;
use App\Models\M_autodebet;

use Excel;
use App\Exports\TransaksiExport;

class AutodebetController extends Controller
{
    //
    public function index(){
      
        
        $data=array(
            'formAction' => url('autodebet/simpan'),
            'nasabah' => M_nasabah::select('norek','nama')->join('rekening','rekening.nin','=','nasabah.nin')->get(),
            'rekening' => M_rekening::select('norek','nama',
                        DB::raw("(SELECT count(*) FROM subrekening WHERE subrekening.norek=rekening.norek) as subrek") 
                        )           
                        ->join('nasabah','nasabah.nin','=','rekening.nin')->get(),
            'autodebet' => M_autodebet::select('rekening.*','nasabah.nama','subrekening.subrekening','autodebet.*')->join('rekening','rekening.norek','=','autodebet.norek')
                            ->join('nasabah','nasabah.nin','=','rekening.nin')
                            ->join('subrekening','subrekening.idsubrekening','=','autodebet.idsubrekening')->get()
        );
        return view('admin/autodebet')->with($data);
    }

    public function simpan(Request $request){
        $queri = M_autodebet::where('norek','=',$request->norek)->where('norektujuan','=',$request->tujuan)->count();
        if($queri<1){

            DB::table('autodebet')->insert([
                'norek' => $request->norek,
                'norektujuan' => $request->tujuan,
                'idsubrekening' =>$request->jenis,
                'tglpenarikan' => $request->tglpenarikan,
                'status' => $request->status,
                'iduser' => session()->get('iduser')
            ]);
            return redirect('/autodebet')->with(['success' => 'Berhasil disimpan!']);
        }else{
            return redirect('/autodebet')->with(['danger' => 'Tidak berhasil disimpan!']);
        }
    }

    public function hapus($id){
        DB::table('autodebet')->where('idautodebet',$id)->delete();
        return redirect('/autodebet')->with(['success' => 'Berhasil dihapus!']);
    }

    public function proses(){
        //$tgl1 = date('j');
        $tgl1 = 12;
        $queri = M_autodebet::where('tglpenarikan','<=',$tgl1);
        if($queri->count()>0){
            $autodebet = $queri->get();
            foreach($autodebet as $data){
                $tgl2 = date('Y').'-'.date('m').'-'.$data->tglpenarikan;
                $queri2 = M_transaksi::where('transaksi.norek','=',$data->norek)
                            ->where('transaksi.idsubrekening','=',$data->idsubrekening)
                            ->where('transaksi.keterangan','=','autodebet')
                            ->where(DB::raw("DATE_FORMAT(transaksi.waktu,'%Y-%m-%d')"),'<=',$tgl2);
                if($queri2->count()<1){
                    $queri3 = M_rekening::select('nasabah.nin','nasabah.kategori')->join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$data->norek);
                    if($queri3->count()>0){
                        $data3 = $queri3->first();
                        if($data3->kategori == "siswa"){
                            $queri4 = DB::table('siswa')->select('thnmasuk')->where('nin','=',$data3->nin);
                            if($queri4->count()>0){
                                $data4 = $queri4->first();
                                $queri5 = M_subrekening::select('nominal')->where('idsubrekening','=',$data->idsubrekening)
                                        ->where('norek','=',$data->norektujuan)
                                        ->where('thnpembayaran','=',$data4->thnmasuk);
                                if($queri5->count()>0){
                                    $data5 = $queri5->first();
                                    $queri6 = DB::select("CALL lihatSaldo('$data->norek')");
                                    if(count($queri6)>0){
                                        $saldo = ($queri6[0]->setor+$queri6[0]->transfer) - ($queri6[0]->tarik+$queri6[0]->transfer2);
                                        if($saldo>$data5->nominal){
                                            DB::table('transaksi')->insert([
                                                'norek' => $data->norek,
                                                'waktu' =>  date('Y-m-d H:i:s'),
                                                'nominal' => $data5->nominal,
                                                'sandi' => '03',
                                                'jnstransaksi' => 'transfer',
                                                'norektujuan' => $data->norektujuan,
                                                'idsubrekening' => $data->idsubrekening,
                                                'keterangan' => 'autodebet',
                                                'iduser' => session()->get('iduser')
                                            ]);
                                            $data = array(
                                                'code' => '00',
                                            
                                            );
                                        }else{
                                            $data = array(
                                                'code' => '09',
                                                
                                            );
                                        }
                                    }else{
                                        $data = array(
                                            'code' => '08',
                                        );
                                    }
                                    
                                }else{
                                    $data = array(
                                        'code' => '07',

                                    );
                                }
                            }else{
                                $data = array(
                                    'code' => '06',
                                );
                            }

                        }else{
                            $data = array(
                                'code' => '05',
                            );
                        }
                    }else{
                        $data = array(
                            'code' => '04',
                        );
                    }
                }else{
                    $data = array(
                        'code' => '03',
                        //'cek' => $tgl2
                    );
                }

            }

        }else{
            $data = array(
                'code' => '01',
                //'tgl'=>$tgl1
            );
        }

        //return response()->json($data);
    }

}
