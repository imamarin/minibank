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
                  <button class="btn btn-success w-100"  data-toggle="modal" data-target=".bs-example-modal-lg">Ubah Password</button><br><br>
                  <button class="btn btn-info w-100"  data-toggle="modal" data-target=".bs-example-modal-lg2">Ubah PIN</button>
                  
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
</div>

<div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" style="margin-top:80px;">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <form action="{{ url('nasabah/ubahpassword') }}" method="post" id="myForm" name="formData" class="form-horizontal form-label-left" >
          <div class="modal-header">
          <h6 class="modal-title" id="myModalLabel">Masukan Password</h6>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="form-group row ">
                      <div class="col-md-9 col-sm-9 ">
                          <input type="password" name="passlama" value="" class="form-control" required placeholder="Input Password Lama"><br>
                          <input type="password" name="passbaru" value="" id="pb" onkeyup = "addpass();" class="form-control" required placeholder="Password Baru"><br>
                          <input type="password" name="confirmpass" value="" id="cp" onkeyup="konfirmasi();" class="form-control" required placeholder="Confirm Password Baru"><br>
                          <input type="hidden" name="username" value="{{ session()->get('username') }}" class="form-control" required>
                          <span id="validpassword"></span>
                      </div>
                  </div>

              
          </div>
          <div class="modal-footer">
          <button type="submit" name="submit" id="btn" class="btn btn-success" value="proses">Ubah Password</button>
          </div>
      </form>     
      </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true" style="margin-top:80px;">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <form action="{{ url('nasabah/ubahpin') }}" method="post" id="myForm" name="formData" class="form-horizontal form-label-left" >
          <div class="modal-header">
          <h6 class="modal-title" id="myModalLabel">Masukan PIN</h6>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="form-group row ">
                      <div class="col-md-9 col-sm-9 ">
                          <input type="password" name="pinlama" value="" class="form-control" required placeholder="Input PIN Lama"><br>
                          <input type="password" name="pinbaru" value="" id="pb2" onkeyup = "addpass2();" class="form-control" required placeholder="PIN Baru"><br>
                          <input type="password" name="confirmpin" value="" id="cp2" onkeyup="konfirmasi2();" class="form-control" required placeholder="Confirm PIN Baru"><br>
                          <input type="hidden" name="norek" value="{{ session()->get('norek') }}" class="form-control" required>
                          <span id="validpassword2"></span>
                      </div>
                  </div>

              
          </div>
          <div class="modal-footer">
          <button type="submit" name="submit" id="btn2" class="btn btn-success" value="proses">Ubah Password</button>
          </div>
      </form>     
      </div>
  </div>
</div>
<script>
  var btn = document.querySelector("#btn");
  var pb = document.querySelector("#pb");
  var cp = document.querySelector("#cp");
  var btn2 = document.querySelector("#btn2");
  var pb2 = document.querySelector("#pb2");
  var cp2 = document.querySelector("#cp2");

  btn.setAttribute('disabled',true);

  function konfirmasi() {
    var valid = document.querySelector("#validpassword");
    if(cp.value == pb.value){
      cp.style.border = "solid 1px green";
      pb.style.border = "solid 1px green";
      valid.innerHTML="Password sesuai";
      btn.removeAttribute('disabled');
      valid.style.color = "green";
    }else{  
      cp.style.border = "solid 1px red";
      pb.style.border = "solid 1px red";
      btn.setAttribute('disabled',true);
      valid.innerHTML="Password tidak sesuai";
      valid.style.color = "red";
    }
  }

  function addpass() {
    cp.value="";  
  }

  function konfirmasi2() {
    var valid2 = document.querySelector("#validpassword2");
    if(cp2.value == pb2.value){
      cp2.style.border = "solid 1px green";
      pb2.style.border = "solid 1px green";
      valid2.innerHTML="PIN sesuai";
      btn2.removeAttribute('disabled');
      valid2.style.color = "green";
    }else{  
      cp2.style.border = "solid 1px red";
      pb2.style.border = "solid 1px red";
      btn2.setAttribute('disabled',true);
      valid2.innerHTML="PIN tidak sesuai";
      valid2.style.color = "red";
    }
  }

  function addpass2() {
    cp2.value="";  
  }
</script>
@endsection