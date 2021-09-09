
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>
<style>

</style>
<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" style="background-color:#303030"> -->
    <section class="content" style="padding-left:0;padding-right:0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <video id="preview" class="scanvideo" style="width:100%;border:solid 1px red;background:none;margin-top:10px;"></video>

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
                </div>
            </div>
        </div>
    </section>
<!-- </diV> -->