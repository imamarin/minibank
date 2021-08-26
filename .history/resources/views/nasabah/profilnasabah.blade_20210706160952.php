@extends('nasabah/template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"style="margin-bottom:0px;">
    <section class="content" style="padding-left:0;padding-right:0;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <br>
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    @if(file_exists(public_path().'/foto/'.session()->get('induk').'.jpg') || file_exists(public_path().'/foto/'.session()->get('induk').'.png'))
                      <img src="{{ asset('/foto/'.session()->get('foto')) }}" alt="..." class="profile-user-img img-fluid img-circle" style="height:110px">
                    @else
                      <img src="{{ asset('/assets/admin/images/user.png') }}" alt="..." class="profile-user-img img-fluid img-circle">
                    @endif
                  </div>

                  <h3 class="profile-username text-center">{{ $nasabah->nama }}</h3>

                  <p class="text-muted text-center">{{ strtoupper('Nasabah '.$nasabah->kategori) }}</p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Jenis Kelamin</b> <a class="float-right">{{ $nasabah->jk=='L'?'Laki-Laki':'Perempuan'}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>No Handphone</b> <a class="float-right">{{ $nasabah->nohp?$nasabah->nohp:'-' }}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Email</b> <a class="float-right">{{ $nasabah->email?$nasabah->email:'-' }}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Alamat</b> <a class="float-right">{{ $nasabah->alamat?$nasabah->alamat:'-' }}</a>
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