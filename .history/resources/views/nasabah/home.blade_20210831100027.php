@extends('nasabah/template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" align="center" style="margin-bottom:0px;">
    <section class="content" style="padding-left:0;padding-right:0;margin:0">
      <div class="container-fluid" style="padding-left:0;padding-right:0;" style="width:100%;">
          <div class="card card-widget widget-user" style="width:100%;">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-cyan">
                <span><b>Assalamu'alaikum</b>, {{ strtoupper(session()->get('nama')) }}</span>
                <p>
                  <?php
                    $tgl = date('l, d F Y');
                    echo $tgl;
                  ?>
                </p>
              </div>
              <div class="widget-user-image">
                   @if(file_exists(public_path().'/foto/'.session()->get('induk').'.jpg') || file_exists(public_path().'/foto/'.session()->get('induk').'.png'))
                      <img src="{{ asset('/foto/'.session()->get('foto')) }}" alt="..." class="img-circle elevation-2" style='height:110px'>
                    @else
                      <img src="{{ asset('/assets/admin/images/user.png') }}" alt="..." class="img-circle elevation-2">
                    @endif
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <b>~ NOMOR REKENING ~</b>
                      <h3 class="text-success">{{ session()->get('norek') }}</h3>
                      
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
              </div>

          </div>
          <div style="display:flex;justify-content:center">
            <div class="row">
              <div class="col-4">
                    <a class="btn btn-app"  style="width:100%; height:80px;padding-top:25px;" href="{{ url('nasabah/inforek') }}">
                      <i class="fas fa-file-invoice text-yellow " style="font-size:30px;"></i> Info Rekening
                    </a>
              </div>
              <div class="col-4">
                    <a class="btn btn-app"  style="width:100%; height:80px;padding-top:25px;" href="{{ url('nasabah/transfer') }}">
                      <i class="fas fa-upload text-primary" style="font-size:30px;"></i> Transfer
                    </a>
              </div>
              <div class="col-4">
                    <a class="btn btn-app"  style="width:100%; height:80px;padding-top:25px;" href="{{ url('nasabah/pembayaran') }}">
                      <i class="fas fa-coins text-info" style="font-size:30px;"></i> Pembayaran
                    </a>
              </div>
            </div>
            <div class="row">
              
              <div class="col-4">
                    <a class="btn btn-app"  style="width:80%; height:80px;padding-top:25px;">
                      <i class="fas fa-cash-register text-red" style="font-size:30px;"></i> Beli
                    </a>
              </div>
              <div class="col-4">
                    <a class="btn btn-app"  style="width:80%; height:80px;padding-top:25px;">
                      <i class="fas fa-cash-register text-red" style="font-size:30px;"></i> Top Up
                    </a>
              </div>
            </div>
          </div>
        
          

    </div>
   
  </section>
</div>
@endsection