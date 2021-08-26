<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_nasabah;
use App\Models\M_user;
use App\Models\M_rekening;
use App\Models\M_subrekening;
use App\Models\M_transaksi;

class NasabahController extends Controller
{
    //
    public function index(){
        
        $nasabah = M_nasabah::get();
        return view('admin/nasabah')->with(['nasabah'=>$nasabah]);
    }

    public function home(){
        return view('nasabah/home');
    }

    public function profil(){
        $nasabah = M_nasabah::where('iduser','=',session()->get('iduser'))->first();
        return view('nasabah/profilnasabah')->with(['nasabah'=>$nasabah]);
    }

    public function inforekening(){       
        return view('nasabah/inforekening');
    }

    public function cari(Request $request){
        $queri3 = DB::table('nasabah')->select('rekening.*','nasabah.*')->join('rekening','rekening.nin','=','nasabah.nin')
        ->where('rekening.norek','=',$request->norek);
        if($queri3->count()>0){           
            $q3=$queri3->first();
            $data = array(
                'norek' => $q3->norek,
                'nama' => $q3->nama,
                'email' => $q3->email,
                'hp' => $q3->nohp,
                'alamat' => $q3->alamat
            );
        }else{
            $data = array(
                'norek' => "",
                'nama' => "",
                'email' => "",
                'hp' => "",
                'alamat' => ""
            );
        }

        return response()->json($data);
    }

    public function infosaldo(Request $request){
        if(isset($request->submit)){
            $norek = session()->get('norek');
            $pin = $request->pin;
            $queri = M_rekening::where('norek','=',$norek)->where('pin','=',$pin);
            if($queri->count()>0){
                $queri = M_transaksi::select( 
                    DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
                    )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->where('rekening.norek','=',$norek)
                    ->orwhere('transaksi.norektujuan','=',$norek);
                if($queri->count() > 0){
                    $q2 = $queri->first();
                    $data = array(
                        'saldo'=>($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2)
                    );
                    return view('nasabah/infosaldo')->with($data);
                }else{
                    return redirect('/nasabah/home');
                }
            }else{
                return redirect('/nasabah/home');
            }    
        }else{
            return redirect('/nasabah/home');
        }
    }

    public function infomutasi(Request $request){
        if(isset($request->submit)){
            $norek = session()->get('norek');
            $pin = $request->pin;
            $queri = M_rekening::where('norek','=',$norek)->where('pin','=',$pin);
            if($queri->count()>0){
                $tgl1=date('Y-m-d',strtotime($request->tanggal1));
                $tgl2=date('Y-m-d',strtotime($request->tanggal2));
                $norek = session()->get('norek');
                $data = array(
                    'transaksi' => M_transaksi::select('transaksi.*','nasabah.*','subrekening.subrekening',
                    DB::raw("(SELECT nsb.nama FROM nasabah as nsb, rekening as rk WHERE nsb.nin = rk.nin AND rk.norek=transaksi.norektujuan) as penerima"))
                            ->join('rekening','rekening.norek','=','transaksi.norek')
                            ->join('nasabah','nasabah.nin','=','rekening.nin')
                            ->leftjoin('subrekening','subrekening.idsubrekening','=','transaksi.idsubrekening')
                            ->where('transaksi.norek','=',$norek)
                            ->orwhere('transaksi.norektujuan','=',$norek)
                            ->whereBetween('waktu', [$tgl1, $tgl2])
                            ->orderby('waktu','desc')->get(),
                    'norek' => $norek
                );
                return view('nasabah/infomutasi')->with($data);
            }else{
                return redirect('/nasabah/home');
            }    
        }else{
            return redirect('/nasabah/home');
        }
    }

    public function transfer(Request $request){
        return view('nasabah/transfer');
    }

    public function prosestransfer(Request $request){
        $queri = M_nasabah::join('rekening','rekening.nin','=','nasabah.nin')
                ->where('rekening.norek','=',$request->norek)
                ->where('rekening.status','=','1');
        if($queri->count() > 0){
            $q = $queri->first();
            $norek = session()->get('norek');
            $queri2 = M_transaksi::select( 
                DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
                )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
                ->where('rekening.norek','=',$norek)
                ->orwhere('transaksi.norektujuan','=',$norek);
            if($queri2->count() > 0){
                $q2 = $queri2->first();
                $saldo = ($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2);
                if($saldo>=$request->nominal){
                    $data = array(
                        'nama' => $q->nama,
                        'norek' => $q->norek,
                        'nominal' => $request->nominal,
                        'keterangan' => $request->ket,
                        'sukses' => 1
                    );
                    //echo print_r($data);
                }else{
                    $data = array(
                        'sukses' => 0,
                        'pesan' => "Saldo anda tidak cukup!"
                    );

                }
            }else{
                $data = array(
                    'sukses' => 0,
                    'pesan' => "Anda tidak mempunyai saldo!"
                );
            }
           
        }else{
            $data = array(
                'sukses' => 0,
                'pesan' => "Rekening yang anda tujukan tidak terdaftar!"
            );
        }
        return response()->json($data);
    }

    public function bayarTransfer(Request $request){
            $norek = session()->get('norek');
            $pin = $request->pin;
            $queri0 = M_rekening::where('norek','=',$norek)->where('pin','=',$pin);
            if($queri0->count()>0){
                $norek = session()->get('norek');
                $queri2 = M_transaksi::select( 
                    DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
                    DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
                    )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
                    ->where('rekening.norek','=',$norek)
                    ->orwhere('transaksi.norektujuan','=',$norek);
                if($queri2->count() > 0){
                    $q2 = $queri2->first();
                    $saldo = ($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2);
                    if($saldo>=$request->nominal){
                        DB::table('transaksi')->insert([
                            'norek' => $request->norek,
                            'waktu' =>  date('Y-m-d H:i:s'),
                            'nominal' => $request->nominal,
                            'jnstransaksi' => 'transfer',
                            'norektujuan' => $request->tujuan,
                            'idsubrekening' => '-',
                            'keterangan' => $request->keterangan?$request->keterangan:'-',
                            'iduser' => session()->get('iduser')
                        ]);
                        $data = array(
                            'sukses' => 1,
                            'pesan' => "Transaksi Berhasil"
                        );
                    }else{
                        $data = array(
                            'sukses' => 0,
                            'pesan' => "Transaksi Gagal"
                        );
                    }
                }else{
                    $data = array(
                        'sukses' => 0,
                        'pesan' => "Transaksi Gagal"
                    );
                }
            }else{
                $data = array(
                    'sukses' => 0,
                    'pesan' => "PIN yang anda masukan salah!"
                );
            }
            return response()->json($data);
    }

    public function pembayaran(){
        if(session()->get('kategori')=='siswa'){
            $siswa = M_nasabah::join('siswa','nasabah.nin','=','siswa.nin')->where('siswa.nin','=',session()->get('induk'))->first();
            $queri = M_subrekening::where('norek','=','787878')->where('thnpembayaran','=',$siswa->thnmasuk)->where('kategori','=',session()->get('kategori'))->get();
        }else{
            $queri = M_subrekening::where('norek','=','787878')->get();
        }
        $data = array(
            'pembayaran' => $queri
        );
        return view('nasabah/pembayaran')->with($data);
    }

    public function prosespembayaran(Request $request){
        $norek = session()->get('norek');
        $pin = $request->pin;
        $queri0 = M_rekening::where('norek','=',$norek)->where('pin','=',$pin);
        if($queri0->count()>0){
            $norek = session()->get('norek');
            $queri2 = M_transaksi::select( 
                DB::raw("SUM(IF(transaksi.jnstransaksi='setor',transaksi.nominal,0)) as setor"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='tarik',transaksi.nominal,0)) as tarik"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norektujuan='$norek' ,transaksi.nominal,0)) as transfer"),
                DB::raw("SUM(IF(transaksi.jnstransaksi='transfer' AND transaksi.norek='$norek' ,transaksi.nominal,0)) as transfer2")
                )->join('rekening','rekening.norek','=','transaksi.norek')->join('nasabah','nasabah.nin','=','rekening.nin')
                ->where('rekening.norek','=',$norek)
                ->orwhere('transaksi.norektujuan','=',$norek);
            if($queri2->count() > 0){
                $q2 = $queri2->first();
                    $saldo = ($q2->setor+$q2->transfer) - ($q2->tarik+$q2->transfer2);
                    if($saldo>=$request->nominal){
                        DB::table('transaksi')->insert([
                            'norek' => $norek,
                            'waktu' =>  date('Y-m-d H:i:s'),
                            'nominal' => $request->nominal,
                            'jnstransaksi' => 'transfer',
                            'norektujuan' => $request->tujuan,
                            'idsubrekening' => $request->jenis,
                            'keterangan' => $request->keterangan?$request->keterangan:'-',
                            'iduser' => session()->get('iduser')
                        ]);
                        $data = array(
                            'sukses' => 1,
                            'pesan' => "Transaksi Berhasil"
                        );
                    }else{
                        $data = array(
                            'sukses' => 0,
                            'pesan' => "Saldo anda tidak mencukupi"
                        );
                    }
            }else{
                $data = array(
                    'sukses' => 0,
                    'pesan' => "Anda tidak mempunyai saldo"
                );
            }
        }else{
            $data = array(
                'sukses' => 0,
                'pesan' => "PIN yang anda masukan salah!"
            );
        }
        return response()->json($data);
    }

    public function input(Request $request){
        $data = array(
            'nin' => $request->nin,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'username' => $request->alamat,
            'nisn' => $request->nisn,
            'thnmasuk' => $request->thnmasuk,
            'foto' => $request->foto,
            'kategori' => $request->kategori,
            'formAction' => url('nasabah/simpan'),
            'tombol' => "Simpan",
            'readonly' => ""
        );
        return view('admin/addnasabah')->with($data);
    }

    public function simpan(Request $request){
        $queri = M_nasabah::where('nin','=',$request->nin)->count();
        if($queri<1){

            $queri = M_user::where('username','=',$request->username);
            if($queri->count()<1){
                DB::table('users')->insert([
                    'username' => $request->username,
                    'password' => sha1($request->password),
                    'idlevel' => "nsb",
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $data = $queri->first();
                
                if($request->hasFile('image')){
                    $resorce       = $request->file('image');
                    $name   = $request->nin.".".$resorce->getClientOriginalExtension();
                    $resorce->move(\base_path() ."/public/foto", $name);
                    DB::table('nasabah')->insert([
                        'nin' => $request->nin,
                        'nama' => $request->nama,
                        'jk' => $request->jk,
                        'nohp' => $request->nohp,
                        'alamat' => $request->alamat,
                        'foto' => $name,
                        'iduser' => $data->iduser
                    ]);
                }else{
                    DB::table('nasabah')->insert([
                        'nin' => $request->nin,
                        'nama' => $request->nama,
                        'jk' => $request->jk,
                        'nohp' => $request->nohp,
                        'alamat' => $request->alamat,
                        'iduser' => $data->iduser
                    ]);
                }

                if($request->kategori=='siswa'){
                    DB::table('siswa')->insert([
                        'nin' => $request->nin,
                        'nisn' => $request->nisn,
                        'thnmasuk' => $request->thnmasuk
                    ]);
                }
                
                
                return redirect('/nasabah')->with(['success' => 'Berhasil disimpan!']);
            }else{
                return redirect('/nasabah')->with(['warning' => 'Tidak Berhasil disimpan!']);
            }
        }else{
            return redirect('/nasabah')->with(['warning' => 'Tidak berhasil disimpan!']);
        }
    }

    public function edit($id){
        $queri = M_nasabah::where('nin','=',$id);
        if($queri->count()>0){
            $row = M_nasabah::where('nin','=',$id)->first();
            $row2 = M_user::where('iduser','=',$row->iduser)->first();

            if($row->kategori=='siswa'){
                $row3 =  DB::table('siswa')->where('nin','=',$row->nin)->first();
                $data = array(
                    'nin' => $row->nin,
                    'nama' => $row->nama,
                    'jk' => $row->jk,
                    'nohp' => $row->nohp,
                    'alamat' => $row->alamat,
                    'username' => $row2->username,
                    'foto' => $row->foto,
                    'formAction' => url('nasabah/update'),
                    'tombol' => "Update",
                    'readonly' => "readonly",
                    'nisn' => $row3->nisn,
                    'thnmasuk' => $row3->thnmasuk,
                    'kategori' => 'siswa'
                );
            }else{
                $data = array(
                    'nin' => $row->nin,
                    'nama' => $row->nama,
                    'jk' => $row->jk,
                    'nohp' => $row->nohp,
                    'alamat' => $row->alamat,
                    'username' => $row2->username,
                    'foto' => $row->foto,
                    'formAction' => url('nasabah/update'),
                    'tombol' => "Update",
                    'readonly' => "readonly",
                    'nisn' => '',
                    'thnmasuk' => '',
                    'kategori' => $row->kategori
                );
            }
            

            return view('admin/addnasabah')->with($data);
        }else{
            return redirect('/nasabah');
        }
    }

    public function update(Request $request){
        $queri = M_nasabah::where('nin','=',$request->nin);
        if($queri->count()>0){
            

            if($request->hasFile('image')){
                $resorce       = $request->file('image');
                $name   = $request->nin.".".$resorce->getClientOriginalExtension();
                $resorce->move(\base_path() ."/public/foto", $name);
                DB::table('nasabah')->where('nin',$request->nin)->update([
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'nohp' => $request->nohp,
                    'foto' => $name,
                    'alamat' => $request->alamat
                ]);
            }else{
                DB::table('nasabah')->where('nin',$request->nin)->update([
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'nohp' => $request->nohp,
                    'alamat' => $request->alamat
                ]);
            }
            
            $row = $queri->first();
            if(isset($request->password)){
                DB::table('users')->where('iduser',$row->iduser)->update([
                    'username' => $request->username,
                    'password' => sha1($request->password),
                ]);
            }else{
                DB::table('users')->where('iduser',$row->iduser)->update([
                    'username' => $request->username,
                ]);
            }

            if($request->kategori=='siswa'){
                DB::table('siswa')->insert([
                    'nin' => $request->nin,
                    'nisn' => $request->nisn,
                    'thnmasuk' => $request->thnmasuk
                ]);
            }
            
            return redirect('/nasabah')->with(['success' => 'Berhasil diubah!']);
        }else{
            return redirect('/nasabah')->with(['warning' => 'Tidak berhasil diubah!']);
        }
    }

    public function hapus($id){
        DB::table('nasabah')->where('iduser',$id)->delete();
        DB::table('users')->where('iduser',$id)->delete();
        return redirect('/nasabah')->with(['success' => 'Berhasil dihapus!']);
    }

    public function carisiswa(Request $request){
        
    }
}
