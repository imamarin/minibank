
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>
<style>

</style>

                    SCAN QRCODE
                    <br><br><br><br><br><br><br><br><br><br>

                    <video id="preview" class="scanvideo" style="width:100%;border:solid 1px red;background:none;"></video>

                    <script type="text/javascript">

                    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false, backgroundScan: false});

                    scanner.addListener('scan', function (content) {
                        alert(content);

                    });

                    Instascan.Camera.getCameras().then(function (cameras) {

                    if (cameras.length > 0) {
                    if(cameras[1]!=null){
                        scanner.start(cameras[1]);
                        
                    }else{
                        scanner.start(cameras[0]);
                        console.log(Instascan);
                    }

                    } else {

                    document.getElementById('kamera').innerHTML="Kamera Tidak Ditemukan";

                    }

                    }).catch(function (e) {

                    document.getElementById('kamera').innerHTML=e;

                    });

                    </script>
