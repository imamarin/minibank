<style>
.preview-container {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    display: flex;
    width: 100%;
    overflow: hidden;
}
</style>
<body style="background: #263238">
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>
<div class="preview-container">
        
                    <video id="preview2" autoplay="autoplay" class="active" style="width:50%;height:50%;border:solid 5px red"></video>
                    
      

                    <script type="text/javascript">

                    let scanner = new Instascan.Scanner({ video: document.getElementById('preview2'), mirror: false});

                    scanner.addListener('scan', function (content) {
                        alert(content);

                    });

                    Instascan.Camera.getCameras().then(function (cameras) {

                    if (cameras.length > 0) {
                    if(cameras[1]!=null){
                        scanner.start(cameras[1]);
                        
                    }else{
                        scanner.start(cameras[1]);
                     
                    }

                    } else {

                    // document.getElementById('kamera').innerHTML="Kamera Tidak Ditemukan";

                    }

                    }).catch(function (e) {

                    // document.getElementById('kamera').innerHTML=e;

                    });

                    </script>
</div>
</body>