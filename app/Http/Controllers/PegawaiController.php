<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_pegawai;
use App\Models\M_user;

class PegawaiController extends Controller
{
    //
    public function index(){
        
        $pegawai = M_pegawai::get();
        return view('admin/pegawai')->with(['pegawai'=>$pegawai]);
    }

    public function input(Request $request){
        $data = array(
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'username' => $request->alamat,
            'level' => $request->level,
            'foto' => $request->foto,
            'formAction' => url('pegawai/simpan'),
            'tombol' => "Simpan",
            'readonly' => ""
        );

        return view('admin/addpegawai')->with($data);
    }

    public function simpan(Request $request){
        $queri = M_pegawai::where('nip','=',$request->nip)->count();
        if($queri<1){

            $queri = M_user::where('username','=',$request->username);
            if($queri->count()<1){
                DB::table('users')->insert([
                    'username' => $request->username,
                    'password' => sha1($request->password),
                    'idlevel' => $request->level,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $data = $queri->first();
                if($request->hasFile('image')){
                    $resorce       = $request->file('image');
                    $name   = $request->nin.".".$resorce->getClientOriginalExtension();
                    $resorce->move(\base_path() ."/public/foto/pegawai", $name);
                    DB::table('pegawai')->insert([
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'jk' => $request->jk,
                        'nohp' => $request->nohp,
                        'alamat' => $request->alamat,
                        'foto' => $name,
                        'iduser' => $data->iduser
                    ]);
                }else{
                    DB::table('pegawai')->insert([
                        'nip' => $request->nip,
                        'nama' => $request->nama,
                        'jk' => $request->jk,
                        'nohp' => $request->nohp,
                        'alamat' => $request->alamat,
                        'iduser' => $data->iduser
                    ]);
                }
                
                

                return redirect('/pegawai')->with(['success' => 'Berhasil disimpan!']);
            }else{
                return redirect('/pegawai')->with(['warning' => 'Tidak Berhasil disimpan1!']);
            }
        }else{
            return redirect('/pegawai')->with(['warning' => 'Tidak berhasil disimpan2!']);
        }
    }

    public function edit($id){
        $queri = M_pegawai::where('nip','=',$id);
        if($queri->count()>0){
            $row = M_pegawai::where('nip','=',$id)->first();
            $row2 = M_user::where('iduser','=',$row->iduser)->first();
            $data = array(
                'nip' => $row->nip,
                'nama' => $row->nama,
                'jk' => $row->jk,
                'nohp' => $row->nohp,
                'alamat' => $row->alamat,
                'level' => $row2->idlevel,
                'username' => $row2->username,
                'foto' => $row->foto,
                'formAction' => url('pegawai/update'),
                'tombol' => "Update",
                'readonly' => "readonly"
            );
            return view('admin/addpegawai')->with($data);
        }else{
            return redirect('/pegawai');
        }
    }

    public function update(Request $request){
        $queri = M_pegawai::where('nip','=',$request->nip);
        if($queri->count()>0){
            
            
            if($request->hasFile('image')){
                $resorce       = $request->file('image');
                $name   = $request->nip.".".$resorce->getClientOriginalExtension();
                $resorce->move(\base_path() ."/public/foto", $name);
                DB::table('pegawai')->where('nip',$request->nip)->update([
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'nohp' => $request->nohp,
                    'foto' => $name,
                    'alamat' => $request->alamat
                ]);
            }else{
                DB::table('pegawai')->where('nip',$request->nip)->update([
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
                    'idlevel' => $request->level,
                    'password' => sha1($request->password),
                ]);
            }else{
                DB::table('users')->where('iduser',$row->iduser)->update([
                    'username' => $request->username,
                    'idlevel' => $request->level,
                ]);
            }
            
            return redirect('/pegawai')->with(['success' => 'Berhasil diubah!']);
        }else{
            return redirect('/pegawai')->with(['warning' => 'Tidak berhasil diubah!']);
        }
    }

    public function hapus($id){
        DB::table('pegawai')->where('iduser',$id)->delete();
        DB::table('users')->where('iduser',$id)->delete();
        return redirect('/pegawai')->with(['success' => 'Berhasil dihapus!']);
    }

}
