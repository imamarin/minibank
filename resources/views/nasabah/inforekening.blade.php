@extends('nasabah/template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"style="margin-bottom:0px;">
    <section class="content" style="padding-left:0;padding-right:0;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <br>
            <div class="card card-cyan card-outline">
                <div class="card-body box-profile">

                  <h3 class="profile-username text-center">INFO REKENING</h3>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><b>Informasi Saldo</b></a>
                    </li>
                    <li class="list-group-item">
                      <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg2"><b>Tangga Mutasi</b></a>
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

                        <div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" style="margin-top:80px;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form action="{{ url('nasabah/infosaldo') }}" method="post" id="myForm" name="formData" class="form-horizontal form-label-left" >
                                    <div class="modal-header">
                                    <h6 class="modal-title" id="myModalLabel">Masukan No PIN</h6>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                            {{ csrf_field() }}
                                            <div class="form-group row ">
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="password" inputmode="numeric" name="pin" pattern="\d*" value="" class="form-control" required placeholder="PIN">
                                                    <input type="hidden" name="norek" value="{{ session()->get('norek') }}" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>

                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" name="submit" id="btn" class="btn btn-primary" value="proses">PROSES</button>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>

                        <div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true" style="margin-top:80px;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form action="{{ url('nasabah/infomutasi') }}" method="post" id="myForm" name="formData" class="form-horizontal form-label-left" >
                                    <div class="modal-header">
                                    <h6 class="modal-title" id="myModalLabel">Tanggal Mutasi</h6>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                            {{ csrf_field() }}
                                            <div class="form-group row ">
                                                <div class="col-md-9 col-sm-9 ">
                                                <label class="control-label col-md-3 col-sm-3 ">Dari Tanggal
                                                </label>
                                                    <input type="date" name="tanggal1" value="" class="form-control" required placeholder="Dari Tanggal">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <div class="col-md-9 col-sm-9 ">
                                                <label class="control-label col-md-3 col-sm-3 ">Sampai Tanggal
                                                </label>
                                                    <input type="date" name="tanggal2" value="" class="form-control" required placeholder="Sampai Tanggal">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="password" name="pin" inputmode="numeric" value="" class="form-control" required placeholder="PIN">
                                                    <input type="hidden" name="norek" value="{{ session()->get('norek') }}" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" name="submit" id="btn" class="btn btn-primary" value="proses">PROSES</button>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>
@endsection
