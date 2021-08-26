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

                  <h3 class="profile-username text-center">INFORMASI SALDO</h3>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Nomor Rekening</b><a class="float-right">{{ session()->get('norek') }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Saldo</b><a class="float-right">Rp. {{ number_format($saldo,0,',','.') }}</a>
                    </li>
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
@endsection


