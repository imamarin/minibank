<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Session;
use Illuminate\Support\Facades\DB;

class SimulasiController extends Controller
{

    public function index(){
        return view('hosttohost');        
    }

    public function proses(Request $request){
        $h2hUrl = 'http://h2h.smk-ypc.sch.id'; // contoh URL
        $secretKey = 'ahjsg@6567JHJ47KJHksa;pd';
        switch ($request->action) {
            case 'reversal':
                $tangalTransaksi = date('YmdHis');
                $request = array(
                    'kodeBank'             => $request->kodeBank,
                    'kodeChannel'          => $request->kodeChannel,
                    'kodeTerminal'         => $request->kodeTerminal,
                    'nomorPembayaran'      => $request->nomorPembayaran,
                    'tanggalTransaksi'     => $tangalTransaksi,
                    'tanggalTransaksiAsal' => $request->tanggalTransaksiAsal,
                    'nomorJurnalPembukuan' => $request->nomorJurnalPembukuan,
                    'idTransaksi'          => $request->nomorPembayaran.$tangalTransaksi,
                    'idTagihan'            => $request->idTagihan,
                    'totalNominal'         => $request->totalNominal,
                    'checksum'             => sha1($request->nomorPembayaran.$secretKey.$tangalTransaksi)
                );
                $fields = array(
                    'action'  => 'reversal',
                    'request' => json_encode($request)
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $h2hUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
                $output = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Timeout';
                } else {
                    curl_close($ch);
                    $output = trim($output);
                    $result = json_decode($output,true);
                    if (!$result) {
                        echo 'Salah Format Message<br>' . htmlentities($output);
                    } else {
                        $code = $result['code'];
                        if ($code != '00') {
                            echo 'Gagal Payment<br>' . htmlentities($output);
                        } else {
                            echo htmlentities($output);
                            echo '<h1>Pembayaran telah dibatalkan</h1>';
                        }
                    }
                }
                echo '<br /><input type="reset" name="back" value="back" onclick="document.location.href=\'simulasi.php\';" />';
                break;
            case 'payment':
                $tangalTransaksi = date('YmdHis');
                $inquiryResponse = html_entity_decode($request->inquiryResponse,ENT_QUOTES);
                $inquiryResponseArray = json_decode($inquiryResponse,true);
                if ($inquiryResponseArray === false){
                    echo 'Salah Format Message inquiry response<br>' . htmlentities($inquiryResponse);
                } else {
                    $request = array(
                        'kodeBank'             => $request->kodeBank,
                        'kodeChannel'          => $request->kodeChannel,
                        'kodeTerminal'         => $request->kodeTerminal,
                        'nomorPembayaran'      => $inquiryResponseArray['data']['nomorPembayaran'],
                        'tanggalTransaksi'     => $tangalTransaksi,
                        'idTransaksi'          => $inquiryResponseArray['data']['nomorPembayaran'] . $tangalTransaksi,
                        'idTagihan'            => $inquiryResponseArray['data']['idTagihan'],
                        'totalNominal'         => $inquiryResponseArray['data']['totalNominal'],
                        'nomorJurnalPembukuan' => uniqid(),
                        'rincianTagihan'       => $inquiryResponseArray['data']['rincianTagihan'],
                        'checksum'             => sha1($inquiryResponseArray['data']['nomorPembayaran'].$secretKey.$tangalTransaksi)
                    );
                    $fields = array(
                        'action'  => 'payment',
                        'request' => json_encode($request)
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $h2hUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
                    $output = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Timeout';
                    } else {
                        curl_close($ch);
                        $output = trim($output);
                        $result = json_decode($output,true);
                        if (!$result) {
                            echo 'Salah Format Message<br>' . htmlentities($output);
                        } else {
                            $code = $result['code'];
                            if ($code != '00') {
                                echo 'Gagal Payment<br>' . htmlentities($output);
                            } else {
                                echo '<pre>Raw Output:<br> '.htmlentities($output).'</pre><hr>';
                                echo '<table>';
                                echo '<tr><td>Nomor Pembayaran</td><td>:</td><td>' . $result['data']['nomorPembayaran'] . '</td></tr>';
                                echo '<tr><td>Nama</td><td>:</td><td>' . $result['data']['nama'] . '</td></tr>';
                                echo '<tr><td>Nomor Induk</td><td>:</td><td>' . $result['data']['nomorInduk'] . '</td></tr>';
                                echo '<tr><td>Fakultas</td><td>:</td><td>' . $result['data']['fakultas'] . '</td></tr>';
                                echo '<tr><td>Jurusan</td><td>:</td><td>' . $result['data']['jurusan'] . '</td></tr>';
                                echo '<tr><td>Angkatan</td><td>:</td><td>' . $result['data']['angkatan'] . '</td></tr>';
                                echo '<tr><td>Strata</td><td>:</td><td>' . $result['data']['strata'] . '</td></tr>';
                                echo '<tr><td>Periode</td><td>:</td><td>' . $result['data']['periode'] . '</td></tr>';
        
                                echo '<tr><td>Total Nominal</td><td>:</td><td>' . number_format($request['totalNominal']) . '</td></tr>';
                                echo '</table>';
                                echo '<form method="post" action="simulasi.php"><input type="hidden" name="action" value="reversal" />';
                                echo '<input type="hidden" name="kodeBank" value="' . $request['kodeBank'] . '" />';
                                echo '<input type="hidden" name="kodeChannel" value="' . $request['kodeChannel'] . '" />';
                                echo '<input type="hidden" name="kodeTerminal" value="' . $request['kodeTerminal'] . '" />';
                                echo '<input type="hidden" name="idTagihan" value="' . $result['data']['idTagihan'] . '" />';
                                echo '<input type="hidden" name="totalNominal" value="' . $request['totalNominal'] . '" />';
                                echo '<input type="hidden" name="nomorPembayaran" value="' . $result['data']['nomorPembayaran'] . '" />';
                                echo '<input type="hidden" name="tanggalTransaksiAsal" value="' . $request['tanggalTransaksi'] . '" />';
                                echo '<input type="hidden" name="nomorJurnalPembukuan" value="' . $request['nomorJurnalPembukuan'] . '" />';
                                echo '<br /><input type="submit" name="reversal" value="Batalkan" />';
                                echo '</form>';
                            }
                        }
                    }
                }
                echo '<br /><input type="reset" name="back" value="back" onclick="document.location.href=\'simulasi.php\';" />';
                break;
            case 'inquiry':
                $tangalTransaksi = date('YmdHis');
                $req = array(
                    'kodeBank' => 'BSM',
                    'kodeChannel' => 'IBANK',
                    'kodeTerminal' => uniqid(),
                    'nomorPembayaran' => $request->nomorPembayaran,
                    'tanggalTransaksi' => $tangalTransaksi,
                    'idTransaksi' => $request->nomorPembayaran . $tangalTransaksi,
                    'checksum' => sha1($request->nomorPembayaran.$secretKey.$tangalTransaksi)
                );
                $fields = array(
                    'action' => 'inquiry',
                    'request' => json_encode($req)
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $h2hUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
                $output = curl_exec($ch);
                // echo json_encode($req);
                // print_r(json_decode($output,true));
                if (curl_errno($ch)) {
                    echo "Timed Out";
                } else {
                    curl_close($ch);
                    $output = trim($output);
                    $result = json_decode($output,true);
                    if (!$result) {
                        echo 'Salah Format Message<br>' . htmlentities($output);
                    } else {
                        $code = $result['code'];
                        if ($code != '00') {
                            echo 'Gagal Inquiry<br>' . htmlentities($output);
                        } else {
                            echo '<code>Raw output:<br>'.htmlentities($output).'</code><hr>';
                            echo '<table>';
                            echo '<tr><td>Nomor Pembayaran</td><td>:</td><td>' . $result['data']['nomorPembayaran'] . '</td></tr>';
                            echo '<tr><td>Nama</td><td>:</td><td>' . $result['data']['nama'] . '</td></tr>';
                            echo '<tr><td>Nomor Induk</td><td>:</td><td>' . $result['data']['nomorInduk'] . '</td></tr>';
                            echo '<tr><td>Fakultas</td><td>:</td><td>' . $result['data']['fakultas'] . '</td></tr>';
                            echo '<tr><td>Jurusan</td><td>:</td><td>' . $result['data']['jurusan'] . '</td></tr>';
                            echo '<tr><td>Angkatan</td><td>:</td><td>' . $result['data']['angkatan'] . '</td></tr>';
                            echo '<tr><td>Strata</td><td>:</td><td>' . $result['data']['strata'] . '</td></tr>';
                            echo '<tr><td>Periode</td><td>:</td><td>' . $result['data']['periode'] . '</td></tr>';
                            echo '<tr><td valign="top">Rincian</td><td valign="top">:</td><td valign="top">';
        
                            echo '<table>';
                            foreach ($result['data']['rincianTagihan'] as $d) {
                                echo '<tr><td>' . $d['deskripsiPendek'] . '</td><td>:</td><td align="right">' . number_format($d['nominal']) . '</td></tr>';
                            }
                            echo '</table>';
        
                            echo '</td></tr>';
                            echo '<tr><td>Total Nominal</td><td>:</td><td align="right">' .number_format($result['data']['totalNominal']). '</td></tr>';
                            echo '</table>';
                            echo '<form method="post" action="'.url('simulasi/proses').'"><input type="hidden" name="action" value="payment" />';
                            echo csrf_field();
                            echo '<input type="hidden" name="kodeBank" value="' . $req['kodeBank'] . '" />';
                            echo '<input type="hidden" name="kodeChannel" value="' . $req['kodeChannel'] . '" />';
                            echo '<input type="hidden" name="kodeTerminal" value="' . $req['kodeTerminal'] . '" />';
                            echo '<input type="hidden" name="inquiryResponse" value="' . htmlentities($output,ENT_QUOTES) . '" />';
                            echo '<br /><input type="submit" name="payment" value="Bayar" />';
                            echo '</form>';
                       
                       }
        
                    }
                    //echo "AAAAAAAAAAa";
                }
                echo '<br /><input type="reset" name="back" value="back" onclick="window.history.go(-1);" />';
                break;
        
            default:
                return redirect('simulasi');
        }
    }

}