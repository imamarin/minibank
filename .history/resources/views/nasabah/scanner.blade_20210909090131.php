
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js2/instascan.min.js') }}"></script>
<style>
*{
    overflow: hidden;
}

.scanvideo::after{
    content: '';
    display: block;
    border: solid 2px blue;
    position: absolute;
    z-index: 100000000;
    background-color:red;
    width:100%;
    height:100%;
}

</style>
<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" style="background-color:#303030"> -->
<div class="content-wrapper" style="background-color:#ffffff">
    <section class="content" style="">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="padding-left:-20px;">

                    <video id="preview" class="scanvideo" style="margin-left:-10px;margin-bottom:50px;"></video>
                    <br>
                </div>
            </div>
        </div>
    </section>
</diV>
<script type="text/javascript">
const args = { video: document.getElementById('preview'), mirror: false, backgroundScan: false};

window.URL.createObjectURL = (stream) => {
            args.video.srcObject = stream;
            return stream;
};
let scanner = new Instascan.Scanner(args);

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
@endsection