@extends('admin/template')
@section('content')
<!-- top tiles -->
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Laporan Transaksi</h3>
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
                        <button class="btn btn-primary" name="printmodal" onclick="print()"><i class="fa fa-print"></i></button>
                        <!-- <button class="btn btn-info" name="printmodal2" onclick="print2()"><i class="fa fa-print"></i></button> -->
                        <button class="btn btn-success" name="excelmodal" onclick="excel()"><i class="fa fa-file-excel-o"></i></button>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h3>Total Nominal</h3>
                        <div class="row">
                            <div class="col-md-3">
                                Total Nominal Setoran:
                            </div>
                            <div class="col-md-9">
                                <div class="kredit">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                Total Nominal Tarikan:
                            </div>
                            <div class="col-md-9">
                                <div class="debit">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                Total Nominal Transfer:
                            </div>
                            <div class="col-md-9">
                                <div class="transfer">
                                    
                                </div>
                            </div>
                        </div>
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th>No</th>
                                            <th>Nama Nasabah</th>
                                            <th>Nomor Rekening</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                            $debit = 0;
                                            $kredit = 0;
                                            $transfer = 0;
                                        @endphp
                                        @foreach($transaksi as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->norek }}</td>
                                            <td>{{ $data->jnstransaksi }}</td>
                                            <td align="right">{{ number_format($data->nominal,0,".",",") }}</td>
                                            <td>
                                                <?php
                                                    if ($data->jnstransaksi == "setor") {
                                                        # code...
                                                        $kredit = $kredit + $data->nominal;
                                                    }elseif($data->jnstransaksi == "tarik") {
                                                        # code...
                                                        $debit = $debit - $data->nominal;

                                                    }elseif($data->jnstransaksi == "transfer") {
                                                        # code...
                                                        $transfer = $transfer - $data->nominal;

                                                    }
                                                    
                                                ?>
                                                @if($data->jnstransaksi=='transfer')
                                                    Tujuan Rekening: {{ $data->norektujuan }} ({{ $data->penerima }})<br>
                                                

                                                    @if($data->idsubrekening!='-')
                                                        Sub Rekening: {{ $data->subrekening }}<br>
                                                        Ket: {{ $data->keterangan }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $data->waktu }}</td>
                                        </tr>
                                        @endforeach
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
<script>
    document.getElementById('kredit').innerHTML='{{ $kredit }}';
    document.getElementById('debit').innerHTML='{{ $debit }}';
    document.getElementById('transfer').innerHTML='{{ $transfer }}';
</script>

<div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="" method="GET" name="formData" class="form-horizontal form-label-left" target="_blank">
            
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Buka Rekening</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah
                        </label>
                        <div class="col-md-9 col-sm-9 ">
                        <select name="norek" class="select2"  style="width: 100%;">
                            <option value="semua">Semua Nasabah</option>
                            @foreach($rekening as $row)
                            <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Awal</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="tglawal" value="" class="form-control" required placeholder="Nomor Rekening">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Akhir</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="tglakhir" value="" class="form-control" required placeholder="PIN">
                        </div>
                    </div>                                        
            </div>
            <div class="modal-footer">
            <button type="submit" id="btn" class="btn btn-primary">Cari</button>
            </div>
        </form>     
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="" method="GET" name="formData2" class="form-horizontal form-label-left" target="_blank">
            
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel2">Buka Rekening</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah
                        </label>
                        <div class="col-md-9 col-sm-9 ">
                        <select name="norek2" class="select2"  style="width: 100%;">
                            <option value="semua">Semua Nasabah</option>
                            @foreach($rekening as $row)
                            <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Awal</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="tglawal2" value="" class="form-control" required placeholder="Nomor Rekening">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Tanggal Akhir</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="tglakhir2" value="" class="form-control" required placeholder="PIN">
                        </div>
                    </div>  
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Dari Baris</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" name="baris" value="" class="form-control" required placeholder="Urutan Baris">
                        </div>
                    </div>                                       
            </div>
            <div class="modal-footer">
            <button type="submit" id="btn2" class="btn btn-primary">Cari</button>
            </div>
        </form>     
        </div>
    </div>
</div>

                

@endsection
<script>
function print(){
    $("[name='norek']").val('semua').trigger('change');
    $("[name='tglawal']").val('').trigger('change');
    $("[name='tglakhir']").val('').trigger('change');
    $("[name='pin']").val('').trigger('change');
    document.getElementById("btn").innerHTML="CETAK";
    document.getElementById("myModalLabel").innerHTML="PRINT LAPORAN TRANSAKSI";
    document.getElementsByName("printmodal")[0].setAttribute("data-toggle","modal");
    document.getElementsByName("printmodal")[0].setAttribute("data-target",".bs-example-modal-lg");
    document.getElementsByName("formData")[0].setAttribute("action","{{ url('laporantransaksi/print') }}");
    //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
    
}

function print2(){
    $("[name='norek2']").val('semua').trigger('change');
    $("[name='tglawal2']").val('').trigger('change');
    $("[name='tglakhir2']").val('').trigger('change');
    document.getElementById("btn2").innerHTML="CETAK";
    document.getElementById("myModalLabel2").innerHTML="PRINT BUKU TABUNGAN";
    document.getElementsByName("printmodal2")[0].setAttribute("data-toggle","modal");
    document.getElementsByName("printmodal2")[0].setAttribute("data-target",".bs-example-modal-lg2");
    document.getElementsByName("formData2")[0].setAttribute("action","{{ url('laporantransaksi/printtabungan') }}");
    //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
    
}

function excel(){
    $("[name='norek']").val('semua').trigger('change');
    $("[name='tglawal']").val('').trigger('change');
    $("[name='tglakhir']").val('').trigger('change');
    $("[name='pin']").val('').trigger('change');
    document.getElementById("btn").innerHTML="EKSPOR";
    document.getElementById("myModalLabel").innerHTML="EKSPORT LAPORAN TRANSAKSI (.xls)";
    document.getElementsByName("excelmodal")[0].setAttribute("data-toggle","modal");
    document.getElementsByName("excelmodal")[0].setAttribute("data-target",".bs-example-modal-lg");
    document.getElementsByName("formData")[0].setAttribute("action","{{ url('laporantransaksi/excel') }}");
    //document.getElementsByName("coba"+x)[0].value="aaaaaaaaaaa";
    
}
</script>
