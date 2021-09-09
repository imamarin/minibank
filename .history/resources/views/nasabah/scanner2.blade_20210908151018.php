
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>
<style>
#kamera{
    margin: 0;
    padding: 0;
    padding-bottom: 100px;
    overflow: hidden;
    overflow: auto;
}
</style>

<div id="kamera">
    <video id="preview" class="scanvideo" style="width:100%;height:100px;border:solid 1px red;background:none;"></video>
</div>

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
