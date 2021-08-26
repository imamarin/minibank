@extends('admin/template')
@section('content')
<!-- top tiles -->
<style>
    @media print{
        @page {
            margin-left : 0.5in;
            margin-top : 2in;
        }

        .container{
            display: none;
        }

        #printArea{
            display: block;
            color:black;
            z-index: 100000000000000000;
        }
    }
</style>
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
                        <form action="{{ url('printtabungan/cari') }}" method="get">
                            <div style="float:left;">
                                
                                <select name="norek" class="select2">
                                    <option value="semua">Semua Nasabah</option>
                                    @foreach($rekening as $row)
                                        @if($norek == $row->norek)
                                            <option value="{{ $row->norek }}" selected>{{ $row->norek." | ".$row->nama}}</option>
                                        @else
                                            <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary"><h6><i class="fa fa-search"></i></h6></button>
                                @if($print==1)
                                <button type="button" class="btn btn-info" name="printmodal2" onclick="print2()"><h6><i class="fa fa-print"></i></h6></button>	
                                @endif
                            </div>
                            
                            
                        </form>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th>No</th>
                                            <!-- <th>Nama Nasabah</th>
                                            <th>Nomor Rekening</th> -->
                                            <th>Tanggal/Waktu</th>
                                            <th>Sandi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>Saldo</th>
                                            <th>Paraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $saldo=0;
                                        $no =1 ;
                                    @endphp
                                    @foreach($transaksi as $data)
                                        @php
                                            if($data->jnstransaksi == "setor" || ($data->jnstransaksi == "transfer" AND $data->norektujuan == $norek)){
                                                $saldo = $saldo + $data->nominal;
                                                $kredit = $data->nominal;
                                            }else{
                                                $kredit = "-";
                                            }

                                            if($data->jnstransaksi == "tarik" || ($data->jnstransaksi == "transfer" AND $data->norektujuan != $norek)){
                                                $saldo = $saldo - $data->nominal;
                                                $debit = $data->nominal;
                                            }else{
                                                $debit = "-";
                                            }
                                        @endphp
                                        <tr style="height:30px;font-size: 12px;">
                                            <td>{{ $no }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($data->waktu)) }}</td>
                                            <td>{{ $data->sandi }}</td>
                                            <td>{{ $debit }}</td>
                                            <td>{{ $kredit  }}</td>
                                            <td>{{ $saldo }}</td>
                                            <td>
                                                {{ $data->paraf }}
                                                <!-- @if($data->jnstransaksi=='transfer')
                                                    Tujuan Rekening: {{ $data->norektujuan }} ({{ $data->penerima }})<br>
                                                

                                                    @if($data->idsubrekening!='-')
                                                        Sub Rekening: {{ $data->subrekening }}<br>
                                                        Ket: {{ $data->keterangan }}
                                                    @endif
                                                @else
                                                    -
                                                @endif -->
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                        
                                    </tbody>

                                </table>
                                <br>
                                   				
                            </div>
                        </div>
                     </div>
                </div>
            </div>
</div>
</div>
</div>

<div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true" id="modal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="{{ url('printtabungan/cetak') }}" method="GET" name="formData2" class="form-horizontal form-label-left">
            
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
                        <!-- <input type="text" name="norek2" class="form-control" value=""> -->
                        <select name="norek2" id="norek2" class="select2"  style="width: 100%;">
                            @foreach($rekening as $row)
                                @if($norek == $row->norek)
                                    <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                @endif
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Dari Record</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="awalrecord" id="awalrecord" class="select2"  style="width: 100%;">
                                @for($i=1;$i<=$no-1;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Sampai Record</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="akhirrecord" id="akhirrecord" class="select2"  style="width: 100%;">
                                @for($i=1;$i<=$no;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>   -->
                    <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Awal Baris Print</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" name="baris" id="baris" value="" class="form-control" required placeholder="Urutan Baris">
                        </div>
                    </div>                                       
            </div>
            <div class="modal-footer">
            <button type="submit" id="btn2" class="btn btn-primary">Cari</button>
            <button type="button" onclick="print3()" id="btn2" class="btn btn-primary">Cari</button>

            </div>
        </form>     
        </div>
    </div>
</div>

<script>

function print2(){
    // $("[name='tglawal2']").val('').trigger('change');
    // $("[name='tglakhir2']").val('').trigger('change');
    document.getElementById("btn2").innerHTML="CETAK";
    document.getElementById("myModalLabel2").innerHTML="PRINT BUKU TABUNGAN";
    document.getElementsByName("printmodal2")[0].removeAttribute("data-dismiss");
    document.getElementsByName("printmodal2")[0].setAttribute("data-toggle","modal");
    document.getElementsByName("printmodal2")[0].setAttribute("data-target",".bs-example-modal-lg2");
    document.getElementsByName("formData2")[0].setAttribute("action","{{ url('printtabungan/cetak') }}");
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

function print3(){
	$.post("{{ url('printtabungan/cetak') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek2: document.getElementById('norek2').value,
                awalrecord: document.getElementById('awalrecord').value,
                // akhirrecord: document.getElementById('akhirrecord').value,
                baris: document.getElementById('baris').value
            }, 
            function(data, status){
                document.getElementById('printArea').innerHTML = data 
                $('#modal2').modal('hide');
                setTimeout(() => {
                    window.print();  
                }, 1000);
                
                // alert(data);
        });


}
</script>


@endsection

