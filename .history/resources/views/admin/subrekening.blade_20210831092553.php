@extends('admin/template')
@section('content')
<!-- top tiles -->
    <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Sub Rekening</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                @if ($message = Session::get('danger'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
							</div>
						</div>
					</div>
                    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        Input Sub Rekening
                        <ul class="nav navbar-right panel_toolbox">
                        
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ $formAction }}" method="post" name="formData" class="form-horizontal form-label-left">
                                    {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $rekening->nama }}" readonly> 
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nomor Rekening</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="norek" id="norek" value="{{ $rekening->norek }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nomor Induk Nasabah</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="nin" id="nin" value="{{ $rekening->nin }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Kode Sub Rekening</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="kdsubrekening" id="kdsubrekening">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Sub Rekening</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="subrekening" id="subrekening">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Tahun Pembayaran</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select name="thnpembayaran" class="select2"  style="width: 100%;">
                                        @for($a=date('Y');$a>=2020;$a--)
											<option value="{{ $a }}">{{ $a }}</option>
										@endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Kategori</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select class="select2" name="kategori" id="kategori" style="width: 100%;" >
                                            <option value="siswa">Siswa</option>
                                            <option value="umum">Umum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nominal</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="nominal" id="nominal">
                                    </div>
                                </div>
                                
                                
								<div class="form-group">
								    <div class="col-md-12 col-sm-12  offset-md-9">
										<button type="submit" id="btn" class="btn btn-success">Proses</button>
									</div>
								</div>
                                </form>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="x_panel">
                    <div class="x_title">
                        
                        Data Sub Rekening
                        
                        <ul class="nav navbar-right panel_toolbox">
                        <li><a href=#><i class="fa fa-print"></i></a>
                        </li>
                        <li><a href=#><i class="fa fa-file-excel-o"></i></a>
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
                                            <th>Nomor Rekening</th>
                                            <th>Sub Rekening</th>
                                            <th>Nominal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach($subrekening as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td>No Rek. {{ $data->norek }}</td>
                                            <td>Kode: {{ $data->idsubrekening }}<br>
                                            Nama Sub: {{ $data->subrekening }}<br>
                                            Tahun: {{ $data->thnpembayaran }}</td>
                                            <td>{{ $data->nominal }}</td>
                                            <td>
                                            <button type="button" name="editmodal<?= $no ?>" class="btn btn-primary" onclick="edit('{{ $no }}','{{ $data->norek }}','{{ $data->idsubrekening }}','{{ $data->subrekening }}','{{ $data->thnpembayaran }}','{{ $data->kategori }}','{{ $data->nominal }}')">Edit</button>
                                            <a href="{{ url('rekening/hapus',['id'=>$data->norek]) }}" onclick="return confirm('Hapus Data ini?')"><button class="btn btn-danger">Hapus</button></a>         
                                            </td>
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

@endsection

<script type="text/javascript">

    var formatter = new Intl.NumberFormat('ID', {
        style: 'currency',


        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
    
    function cariData2(x){
        $.post("{{ route('transfer.cari') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x
            }, 
            function(data, status){
                document.getElementById('nin').value=data.nin;
                document.getElementById('norek').value=data.norek;
                document.getElementById('saldo').value="Rp. "+new Number(data.saldo).toLocaleString("ID");
                document.getElementById('tujuan').removeAttribute('disabled');
                

        });
    }

    function cariData3(x){
        $.post("{{ route('transfer.caripembayaran') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x
            }, 
            function(data,success){
                if(data!=""){
                    document.getElementById('pembayaran').innerHTML=data;
                    document.getElementById('divpembayaran').removeAttribute('style');
                    document.getElementById('divketerangan').removeAttribute('style');
                }else{
                    document.getElementById('divpembayaran').style.display="none";
                    document.getElementById('divketerangan').style.display="none";
                }

        });
    }

    function formatRupiah(angka){
		return formatter.format(angka);
	}


    function edit(x,a,b,c,d,e,f){

        document.getElementById("kdsubrekening").value = b;
        document.getElementById("subrekening").value = c;
        $("[name='thnpembayaran']").val(d).trigger('change');
        $("[name='kategori']").val(e).trigger('change');
        // document.getElementById("kategori").value = e;
        document.getElementById("nominal").value = f;
        document.getElementsByName("kdsubrekening")[0].setAttribute("readonly","true");
        document.getElementById("btn").innerHTML="UPDATE";
        document.getElementsByName("formData")[0].setAttribute("action","{{ url('rekening/updatesub') }}");
        //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
        
    }
    
</script>