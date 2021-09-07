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
          <div class="col-md-3">
            <br>
            <div class="card card-cyan card-outline">
                <div class="card-body box-profile">

                  <h3 class="profile-username text-center" id="titlepembayaran">DAFTAR PEMBAYARAN</h3>

                  <ul class="list-group list-group-unbordered mb-3" id="listPembayaran">
                    @foreach($pembayaran as $data)
                    <li class="list-group-item">
                        <a class="font-weight-bold" onclick="cariData('{{ $data->idsubrekening }}','{{ $data->subrekening }}','{{ $data->nominal }}','{{ $data->norek }}')">{{ $data->subrekening }}</a>
                    </li>
                    @endforeach
                  </ul>

                  <ul class="list-group list-group-unbordered mb-3" id="cekPembayaran" style="display:none;">
                    <li class="list-group-item">
                        <b>Nama Pembayaran</b><a class="float-right" id="namapembayaran"></a>
                    </li>
                    <li class="list-group-item">
                        <b>Nominal</b><a class="float-right" id="nominal"></a>
                    </li>
                    <li class="list-group-item">
                        <b>Keterangan</b><br>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </li>
                    <br>
                    <center>Jika sudah benar, Yakin untuk melakukan transkasi pembayaran?<center>
                    <br>
                    <input type="password" inputmode="numeric" name="pin" id="pin" class="form-control" placeholder="Masukan PIN"><br>
                    <a href="{{ url('nasabah/home') }}" class="btn btn-danger">Batalkan</a>
                    <button type="button" onclick="simpanData()" class="btn btn-primary">Bayar</button>
                  </ul>
                 
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
</div>
<script>
    var kdpembayaran = "";
    var rek = "";
    var nom = 0;
    function cariData(x,y,z,n){
        kdpembayaran = x;
        rek = n;
        nom = z;
        document.getElementById('listPembayaran').style.display="none";
        document.getElementById('cekPembayaran').removeAttribute('style');
        document.getElementById('namapembayaran').innerHTML=y;
        document.getElementById('nominal').innerHTML=z;
        document.getElementById('titlepembayaran').innerHTML="KONFIRMASI PEMBAYARAN";
    }

    function simpanData(){
        p = document.getElementById('pin').value;
        
        $.post("{{ route('nasabah.prosespembayaran') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                tujuan: rek,
                nominal: nom,
                keterangan: document.getElementById('keterangan').value,
                jenis: kdpembayaran,
                pin: p
            }, 
            function(data,success){
                if(data.sukses==1){
                    document.getElementById('titlepembayaran').innerHTML="STATUS PEMBAYARAN";
                    document.getElementById('cekPembayaran').innerHTML="<center><b class='text-success'>"+data.pesan+"<b></center>";
                }else{
                    document.getElementById('titlepembayaran').innerHTML="STATUS TRANSFER";
                    document.getElementById('cekPembayaran').innerHTML="<center><b class='text-danger'>"+data.pesan+"<b></center>";
                }
               

        });
    }
</script>
@endsection


