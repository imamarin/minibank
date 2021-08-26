@extends('admin/template')
@section('content')
<!-- top tiles -->
    <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Data Auto Debet</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                @if ($message = Session::get('warning'))
                                <div class="alert alert-warning alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
							</div>
						</div>
					</div>
                    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        
                        <button type="button" class="btn btn-primary" name="inputmodal" onclick="input()">Tambah Auto Debet</button>
                        
                        <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                            </div>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th>No</th>
                                            <th>Nasabah</th>
                                            <th>Rekening Tujuan</th>
                                            <th>Sub Rekening</th>
                                            <th>Tanggal Penarikan</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach($autodebet as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td><b>{{ $data->nama }}</b><br>No Rek. {{ $data->norek }}</td>
                                            <td>{{ $data->norektujuan }}</td>
                                            <td>{{ $data->subrekening }}</td>
                                            <td>{{ $data->tglpenarikan }}</td>
                                            <td>{{ $data->status==1?'Aktif':'Tidak Aktif' }}</td>
                                            <th>
                                           
                                            <a href="{{ url('autodebet/hapus',['id'=>$data->idautodebet]) }}" onclick="return confirm('Hapus Data ini?')"><button class="btn btn-danger">Hapus</button></a>
                                            
                                            </th>
                                        </tr>
                                        @endforeach;
                                    </tbody>
                                </table>
					
					
                            </div>
                        </div>
                     </div>
                </div>
            </div>
</div>
</div>
</div>

<div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form action="{{ $formAction }}" method="post" name="formData" class="form-horizontal form-label-left">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Tambah Auto Debet</h4>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah
                                                </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                <select name="nin" class="select2" onchange="cariData2(this.value)"  style="width: 100%;">
                                                    <option value="">Pilih Nasabah</option>
                                                    @foreach($nasabah as $row)
                                                    <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 col-sm-3 ">Nomor Rekening</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" class="form-control" name="norek" id="norek" value="1 " readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 col-sm-3 ">Nomor Induk Nasabah</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" class="form-control" name="nin" id="nin" value="-" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 col-sm-3 ">Tujuan Rekening</label>
                                                    <div class="col-md-9 col-sm-9 ">
                                                        <select name="tujuan" disabled id="tujuan" onchange="cariData3(this.value)" class="select2" style="width: 100%;">
                                                            <option value="">Pilih Nasabah</option>
                                                            @foreach($rekening as $row)
                                                                @if($row->subrek > 0)
                                                                    <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="form-group row" id="divsubrekening" style="display:none;">
                                                <label class="control-label col-md-3 col-sm-3 ">Sub Rekening</label>
                                                    <div class="col-md-9 col-sm-9 ">
                                                        <select name="jenis" class="select2" style="width: 100%;" id="pembayaran">
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="form-group row" id="divtglpenarikan" style="display:none;">
                                                <label class="control-label col-md-3 col-sm-3 ">Tanggal Penarikan</label>
                                                    <div class="col-md-9 col-sm-9 ">
                                                        <select name="tglpenarikan" class="select2" style="width: 100%;" id="tglpenarikan">
                                                            @for($t=1;$t<=31;$t++)
                                                                <option value='{{ $t }}'>{{ $t }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="form-group row" id="status"  style="display:none;">
                                                <label class="control-label col-md-3 col-sm-3 ">Status Aktivasi
                                                </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                <select name="status" class="select2"  style="width: 100%;">
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                </select>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" id="btn" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>

                
@endsection

<script>
    var thn="";
function edit(x,a,b,c,d){
    $("[name='norek']").val(a).trigger('change');
    $("[name='nin']").val(b).trigger('change');
    $("[name='status']").val(c).trigger('change');
    $("[name='pin']").val(d).trigger('change');
    document.getElementsByName("norek")[0].setAttribute("readonly","true");
    document.getElementById("btn").innerHTML="UPDATE";
    document.getElementById("myModalLabel").innerHTML="EDIT REKENING";
    document.getElementsByName("editmodal"+x)[0].setAttribute("data-toggle","modal");
    document.getElementsByName("editmodal"+x)[0].setAttribute("data-target",".bs-example-modal-lg");
    document.getElementsByName("formData")[0].setAttribute("action","{{ url('rekening/update') }}");
    //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
    
}

function input(){
    $("[name='norek']").val('').trigger('change');
    $("[name='nin']").val('').trigger('change');
    document.getElementById("btn").innerHTML="SIMPAN";
    document.getElementById("myModalLabel").innerHTML="Tambah Auto Debet";
    document.getElementsByName("inputmodal")[0].setAttribute("data-toggle","modal");
    document.getElementsByName("inputmodal")[0].setAttribute("data-target",".bs-example-modal-lg");
    document.getElementsByName("formData")[0].setAttribute("action","{{ url('autodebet/simpan') }}");
    //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
    
}

function cariData3(x){
        $.post("{{ route('transfer.caripembayaran') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x,
                thnmasuk: thn
            }, 
            function(data,success){
                if(data!=""){
                    document.getElementById('pembayaran').innerHTML=data;
                    document.getElementById('divsubrekening').removeAttribute('style');
                    document.getElementById('divtglpenarikan').removeAttribute('style');
                    document.getElementById('status').removeAttribute('style');
                }else{
                    document.getElementById('divsubrekening').style.display="none";
                    document.getElementById('divtglpenarikan').style.display="none";
                    document.getElementById('status').style.display="none";
                }

        });
    }

function cariData2(x){
        $.post("{{ route('transfer.cari') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x
            }, 
            function(data, status){
                document.getElementById('nin').value=data.nin;
                document.getElementById('norek').value=data.norek;
                thn = data.thnmasuk;
                document.getElementById('tujuan').removeAttribute('disabled');
                

        });
    }
</script>
