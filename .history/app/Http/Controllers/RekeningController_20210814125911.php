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

class RekeningController extends Controller
{
    //
    public function index(){
        $data=array(
            'formAction' => url('rekening/simpan'),
            'nasabah' => M_nasabah::select('nin','nama')->get(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get()
        );
        return view('admin/rekening')->with($data);
    }

    public function simpan(Request $request){
        $queri = M_rekening::where('norek','=',$request->norek)->count();
        if($queri<1){

            DB::table('rekening')->insert([
                'norek' => $request->norek,
                'nin' => $request->nin,
                'pin' => sha1($request->pin),
                'created' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'iduser' => session()->get('iduser')
            ]);
            return redirect('/rekening')->with(['success' => 'Berhasil disimpan!']);
        }else{
            return redirect('/rekening')->with(['warning' => 'Tidak berhasil disimpan!']);
        }
    }

    public function update(Request $request){
        $queri = M_rekening::where('norek','=',$request->norek)->count();
        if($queri>0){

            if(isset($request->pin)){
                $updateRow=DB::table('rekening')->where('norek','=',$request->norek)->update([
                    'nin' => $request->nin,
                    'pin' => sha1($request->pin),
                    'status' => $request->status,
                    'iduser' => session()->get('iduser')
                ]);
            }else{
                $updateRow=DB::table('rekening')->where('norek','=',$request->norek)->update([
                    'nin' => $request->nin,
                    'status' => $request->status,
                    'iduser' => session()->get('iduser')
                ]);
            }
            
            
            return redirect('/rekening')->with(['success' => 'Berhasil disimpan!']);
        }else{
            return redirect('/rekening')->with(['warning' => 'Tidak berhasil disimpan!']);
        }
    }

    public function hapus($id){
        DB::table('rekening')->where('norek',$id)->delete();
        return redirect('/rekening')->with(['success' => 'Berhasil dihapus!']);
    }

    public function sub($id){
        $data=array(
            'formAction' => url('rekening/simpansub'),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')
                            ->where('rekening.status','=','1')
                            ->where('rekening.norek','=',$id)
                            ->first(),
            'subrekening' => M_subrekening::join('rekening','rekening.norek','=','subrekening.norek')
                            ->where('rekening.norek','=',$id)->get()
        );
        return view('admin/subrekening')->with($data);
    }

    public function simpansub(Request $request){
        $queri = M_subrekening::where('norek','=',$request->norek)
                    ->where('idsubrekening','=',$request->kdsubrekening)->count();
        if($queri<1){

            DB::table('subrekening')->insert([
                'norek' => $request->norek,
                'idsubrekening' => $request->kdsubrekening,
                'subrekening' => $request->subrekening,
                'thnpembayaran' => $request->thnpembayaran,
                'kategori' => $request->kategori,
                'nominal' => $request->nominal
            ]);
            return redirect()->route('rekening_sub',['id'=>$request->norek])->with(['success' => 'Berhasil disimpan!']);
        }else{
            return redirect()->route('rekening_sub',['id'=>$request->norek])->with(['warning' => 'Tidak berhasil disimpan!']);
        }
    }

    public function updatesub(Request $request){
        $queri = M_subrekening::where('norek','=',$request->norek)
                    ->where('idsubrekening','=',$request->kdsubrekening)->count();
        if($queri>0){

            DB::table('subrekening')->where('idsubrekening','=',$request->kdsubrekening)->update([
                'subrekening' => $request->subrekening,
                'thnpembayaran' => $request->thnpembayaran,
                'kategori' => $request->kategori,
                'nominal' => $request->nominal
            ]);
            return redirect()->route('rekening_sub',['id'=>$request->norek])->with(['success' => 'Berhasil disimpan!']);
        }else{
            return redirect()->route('rekening_sub',['id'=>$request->norek])->with(['warning' => 'Tidak berhasil disimpan!']);
        }
    }

    public function koran(){
        $data = array(
            'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
            DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                    ->join('rekening','rekening.norek','=','transaksi.norek')
                    ->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                    ->where('rekening.status','=','1')
                    ->orderby('waktu','desc')->get(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->get()
        );
        return view('admin/laporantransaksi')->with($data);
    }

    public function printlaptransaksi(Request $request){
        $tgl1=date('Y-m-d',strtotime($request->tglawal));
        $tgl2=date('Y-m-d',strtotime($request->tglakhir));
        $norek = $request->norek;
        if($norek=="semua"){
            $data = array(
                'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                        DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                        ->join('rekening','rekening.norek','=','transaksi.norek')
                        ->join('nasabah','nasabah.nin','=','rekening.nin')
                        ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                        ->whereBetween('waktu', [$tgl1, $tgl2])
                        ->orderby('waktu','desc')->get(),
                'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first(),
                'norek' => $norek
            );
        }else{
            $data = array(
                'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                        DB::raw("(SELECT nsb.nama FROM nasabah as nsb WHERE nsb.nin = nasabah.nin) as penerima"))
                        ->join('rekening','rekening.norek','=','transaksi.norek')
                        ->join('nasabah','nasabah.nin','=','rekening.nin')
                        ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                        ->where('rekening.norek','=',$norek)
                        ->whereBetween('waktu', [$tgl1, $tgl2])
                        ->orderby('waktu','desc')->get(),
                'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first(),
                'norek' => $norek
            );
            
        }
    
        return view('admin/printlaptransaksi')->with($data);
    }

    public function printtabungan(Request $request){
        
        $norek = $request->norek2;
        $data = array(
            'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                    DB::raw("(SELECT nsb.nama FROM nasabah as nsb WHERE nsb.nin = nasabah.nin) as penerima"))
                    ->join('rekening','rekening.norek','=','transaksi.norek')
                    ->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                    ->where('rekening.norek','=',$norek)
                    ->orderby('waktu','asc')->get(),
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$norek)->first(),
            'norek' => $norek,
            'baris' => $request->baris,
            'tgl1' => date('Y-m-d',strtotime($request->tglawal2)),
            'tgl2' => date('Y-m-d',strtotime($request->tglakhir2))
        );

    
        return view('admin/printtabungan')->with($data);
    }

    public function excellaptransaksi(){
        $nama_file = 'laporan_transaksi_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new TransaksiExport, $nama_file);
    }

    public function cetak(Request $request){
        $data=array(
            'rekening' => M_rekening::join('nasabah','nasabah.nin','=','rekening.nin')->where('rekening.norek','=',$request->norek)
        );
        return $request->norek;
    }

}
