
<!-- <style>
body{
    overflow: hidden;
}

#kamera{
    margin-top: 250px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    padding-right: -30px;
    border: solid 1px green;
}

#preview{
    position: relative;
}
</style> -->

<!-- <div id="kamera">
    <video id="preview" class="scanvideo" style="border:solid 1px red;"></video>
</div>

<script type="text/javascript">

let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false});

scanner.addListener('scan', function (content) {
    alert(content);

});

Instascan.Camera.getCameras().then(function (cameras) {

if (cameras.length > 0) {
if(cameras[1]!=null){
    scanner.start(cameras[1]);
    
}else{
    scanner.start(cameras[1]);
    console.log(Instascan);
}

} else {

document.getElementById('kamera').innerHTML="Kamera Tidak Ditemukan";

}

}).catch(function (e) {

document.getElementById('kamera').innerHTML=e;

});

</script> -->

<!DOCTYPE html>
<html>
  <head>
    <title>Instascan</title>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
    <script src="https://minibank.smk-ypc.sch.id/public/assets/js2/instascan.min.js"></script>
  </head>
  <style>
      canvas{
          width:300px;
          height:200px;
      }
  </style>
  <body>
    <video id="preview" style="width:300px;height:300px;"></video>
    <div id="pesan"></div>
    <script type="text/javascript">

        const args = { video: document.getElementById('preview'), mirror:false };

        window.URL.createObjectURL = (stream) => {
                    args.video.srcObject = stream;
                    return stream;
        };
        let scanner = new Instascan.Scanner(args);
        scanner.addListener('scan', function (content) {
            console.log(content);
            document.getElementById('pesan').innerHTML='No cameras found.';
            });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
            scanner.start(cameras[1]);
            document.getElementById('pesan').innerHTML='No came found.';
            } else {
            console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
            document.getElementById('pesan').innerHTML='No cameras found.';
        });
    </script>
  </body>
</html>


<!-- <!DOCTYPE html>
<html>
<head>
	<title>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>
  
    <h1>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</h1>
    
    <video id="preview"></video>
    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        alert(content);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
   
</body>
</html> -->
