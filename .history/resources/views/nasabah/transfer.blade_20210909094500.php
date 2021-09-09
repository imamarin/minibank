@extends('nasabah/template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<script>
    if ( window.history.replaceState ) {
        lokasi = "{{ url('nasabah/home') }}";
        window.history.replaceState( null, null, lokasi);
    }
</script>
<div class="content-wrapper"style="margin-bottom:0px;">
    <section class="content" style="padding-left:0;padding-right:0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3" style="margin-bottom:100px;">
                    <br>
                    <div class="card card-cyan card-outline">
                        <div class="card-body box-profile">
                        <form action="" method="post">
                            <h3 class="profile-username text-center" id="titletransfer">TRANSFER</h3>

                            <ul class="list-group list-group-unbordered mb-3" id="contentTransfer">
                                <li class="list-group-item">
                                    <b>Tujuan Nomor Rekening</b> [<i class="fas fa-qrcode"></i>]<br>
                                    <input type="number" name="norek" id="norek" class="form-control" required>
                                    <br>
                                    <b>Nominal</b><br>
                                    <input type="number" name="nominal" id="nominal" class="form-control" required>
                                    <br>
                                    <b>Keterangan</b><br>
                                    <textarea name="ket" id="ket" class="form-control"></textarea>
                                    
                                </li> 
                                <button type="button" class="btn btn-primary btn-block" onclick="cariData();" id="btntransfer"><b>Berikutnya</b></button>
                            </ul>

                            <ul class="list-group list-group-unbordered mb-3" id="ketTransfer" style="display:none">
                                <li class="list-group-item">
                                    <b>Tujuan Nomor Rekening</b><a class="float-right" id='tujuan'></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Atas Nama</b><a class="float-right" id='nama'></a>
                                </li> 
                                <li class="list-group-item">
                                    <b>Nominal</b><a class="float-right" id='nominaltransfer'></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Keterangan</b><a class="float-right" id='keterangan'></a>
                                </li>
                                <br>
                                <center>Jika sudah benar, Yakin untuk melakukan transkasi transfer?<center>
                                <br>
                                <input type="password" inputmode="numeric" name="pin" id="pin" class="form-control" placeholder="Masukan PIN"><br>
                                <a href="{{ url('nasabah/home') }}" class="btn btn-danger">Batalkan</a>
                                <button type="button"onclick="simpanData()" class="btn btn-primary">Transfer </button>
                            </ul>
                            
                            
                            
                            
                            
                        </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    var x="";
    var y=0;
    var z="";
    function cariData(){
        x = document.getElementById('norek').value;
        y = document.getElementById('nominal').value;
        z = document.getElementById('ket').value;
        $.post("{{ route('nasabah.prosestransfer') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x,
                nominal: y,
                ket: z
            }, 
            function(data,success){
                if(data.sukses==1){
                    document.getElementById('contentTransfer').style.display="none";
                    document.getElementById('ketTransfer').removeAttribute('style');
                    document.getElementById('titletransfer').innerHTML="KONFIRMASI TRANSFER";
                    document.getElementById('tujuan').innerHTML = data.norek;
                    document.getElementById('nama').innerHTML = data.nama;
                    document.getElementById('nominaltransfer').innerHTML = data.nominal;
                    document.getElementById('keterangan').innerHTML = data.keterangan;
                    document.getElementById('btntransfer').innerHTML="Transfer";
                }else{
                    document.getElementById('contentTransfer').innerHTML=data.pesan;
                    document.getElementById('btntransfer').style.display="none";
                    document.getElementById('cancelbtntransfer').style.display="none";
                }
               

        });
    }

    function simpanData(){
        p = document.getElementById('pin').value;

        $.post("{{ route('nasabah.bayartransfer') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: {{ session()->get('norek') }},
                tujuan: x,
                nominal: y,
                keterangan: z,
                pin: p
            }, 
            function(data,success){
                if(data.sukses==1){
                    document.getElementById('titletransfer').innerHTML="STATUS TRANSFER";
                    document.getElementById('ketTransfer').innerHTML="<center><b class='text-success'>"+data.pesan+"<b></center>";
                }else{
                    document.getElementById('titletransfer').innerHTML="STATUS TRANSFER";
                    document.getElementById('ketTransfer').innerHTML="<center><b class='text-danger'>"+data.pesan+"<b></center>";
                }
               

        });
    }
</script>
@endsection




