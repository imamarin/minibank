
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>
<style>
body{
    overflow: hidden;
}

#kamera{
    margin-top: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    padding-right: -10px;
    border: solid 1px green;
}

#preview{
    position: static;
}
</style>

<div id="kamera">
    <video id="preview" class="scanvideo" style="width:70%;border:solid 1px red;background:none;"></video>
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
