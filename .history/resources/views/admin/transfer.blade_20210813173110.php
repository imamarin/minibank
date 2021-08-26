@extends('admin/template')
@section('content')
<!-- top tiles -->
    <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Transaksi Transfer Tabungan</h3>
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
                        Input Transaksi Transfer Tabungan
                        <ul class="nav navbar-right panel_toolbox">
                        
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="{{ $formAction }}" method="post" id="form1" class="form-horizontal form-label-left">
                                    {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select name="nsb" onchange="cariData2(this.value)" class="select2" style="width: 100%;" require>
                                                <option value="">Pilih Nasabah</option>
                                                @foreach($rekening as $row)
                                                <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nomor Rekening</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="norek" id="norek" readonly required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Nomor Induk Nasabah</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="nin" id="nin" readonly required>
                                        <input type="hidden" class="form-control" name="thnmasuk" id="thnmasuk" value="-" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Saldo</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="saldo" id="saldo" value="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Tujuan Rekening</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select name="tujuan" id="tujuan" disabled onchange="cariData3(this.value)" class="select2" style="width: 100%;" require>
                                                <option value="">Pilih Nasabah</option>
                                                @foreach($rekening as $row)
                                                <option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>
                                                @endforeach
                                            </select>
                                            </select>
                                        </div>
                                </div>
                                
                                <div class="form-group row" id="divpembayaran" style="display:none;">
                                    <label class="control-label col-md-3 col-sm-3 ">Sub Rekening</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select name="jenis" class="select2" onchange="cariData4(this.value)" style="width: 100%;" id="pembayaran" required>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row" id="divnominalpembayaran" style="display:none;">
                                    <label class="control-label col-md-3 col-sm-3 ">Nominal</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" name="nominalpembayaran" id="nominalpembayaran" value="" readonly required>
                                    </div>
                                </div>
                                <div class="form-group row" id="divketerangan" style="display:none;">
                                    <label class="control-label col-md-3 col-sm-3 ">Keterangan</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <textarea name="keterangan" class="form-control"></textarea>
                                        </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group row">
                                    <label class="control-label col-md-1 col-sm-1 ">Rp. </label>
                                    <div class="col-md-11 col-sm-11">
										<input type="text" name="nominal" id="nominal" class="form-control" placeholder="Nominal Transfer" required>
									</div>
                                    <script type="text/javascript">
                                        var rupiah = document.getElementById('nominal');
                                        rupiah.addEventListener('keyup', function(e){
                                            // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
                                            // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
                                            rupiah.value = formatRupiah(this.value, 'Rp. ');
                                        });
                                        /* Fungsi formatRupiah */
                                        function formatRupiah(angka, prefix){
                                            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                            split           = number_string.split(','),
                                            sisa             = split[0].length % 3,
                                            rupiah             = split[0].substr(0, sisa),
                                            ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
                                            nominal = split;
                                            // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
                                            if(ribuan){
                                                separator = sisa ? '.' : '';
                                                rupiah += separator + ribuan.join('.');
                                            }
                                
                                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                                        }
                                    </script>
								</div>
								<div class="form-group">
								    <div class="col-md-12 col-sm-12  offset-md-9">
										<button type="button" class="btn btn-success" onclick="proses()">Proses</button>
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
                        
                        Data Transaksi Transfer Tabungan
                        
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
                                            <th>Nasabah Pengirim</th>
                                            <th>Nasabah Penerima</th>
                                            <th>Nominal</th>
                                            <th>Waktu Transaksi</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach($tabungan as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td><b>{{ strtoupper($data->nama) }}</b><br>No Rek. {{ $data->norek }}</td>
                                            <td>No Rek. {{ $data->norektujuan }}</td>
                                            <td>Rp. {{ number_format($data->nominal,0,'','.') }}</td>
                                            <td>{{ $data->waktu }}</td>
                                            <td>
                                                @if($data->idsubrekening!='-')
                                                    Sub Rekening: {{ $data->subrekening }}<br>
                                                    Ket: {{ $data->keterangan }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><a href="{{ url('transfer/hapus',['id'=>$data->idtransaksi]) }}" onclick="return confirm('Batalkan transaksi ini?')" class="btn btn-danger fa fa-close" ></a></td>
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
    var saldonasabah = 0;
    var nominal = 0;
    var nominalpembayaran = 0;
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
                document.getElementById('thnmasuk').value=data.thnmasuk;
                saldonasabah = data.saldo;
                nominalpembayaran = 0;
                if(data.sukses==1){
                    document.getElementById('saldo').value="Rp. "+new Number(data.saldo).toLocaleString("ID");
                    document.getElementById('tujuan').removeAttribute('disabled');
                }else{
                    document.getElementById('saldo').value="";
                    document.getElementById('tujuan').setAttribute('disabled','disabled');
                }
                $("[name='tujuan']").val('').trigger('change');
                document.getElementById('divpembayaran').style.display="none";
                document.getElementById('divnominalpembayaran').style.display="none";
                document.getElementById('divketerangan').style.display="none";
        });
    }

    function cariData3(x){
        $.post("{{ route('transfer.caripembayaran') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x,
                thnmasuk: document.getElementById('thnmasuk').value
            }, 
            function(data,success){
                if(data!=""){
                    nominalpembayaran = 0;
                    document.getElementById('pembayaran').innerHTML=data;
                    document.getElementById('divpembayaran').removeAttribute('style');
                    document.getElementById('divnominalpembayaran').removeAttribute('style');
                    document.getElementById('divketerangan').removeAttribute('style');
                }else{
                    document.getElementById('divpembayaran').style.display="none";
                    document.getElementById('divnominalpembayaran').style.display="none";
                    document.getElementById('divketerangan').style.display="none";
                }

        });
    }

    function cariData4(x){
        $.post("{{ route('transfer.carinominalpembayaran') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                pembayaran: x,
                thnmasuk: document.getElementById('thnmasuk').value
            }, 
            function(data,success){
                nominalpembayaran = data;
                document.getElementById('nominalpembayaran').value="Rp. "+new Number(data).toLocaleString("ID");
                document.getElementById('nominal').value= formatRupiah(data,0);

        });
    }

    function formatRupiah(angka){
		return formatter.format(angka);
	}

    function proses(){

        if(saldonasabah > nominal){
            if(nominalpembayaran !=0 ){
                if(nominalpembayaran <= nominal){
                    document.getElementById('form1').submit();
                }else{
                    alert("Maaf, nominal anda tidak mencukupi!")
                }
            }else{
                document.getElementById('form1').submit();
            }
        }else{
            alert("Maaf saldo anda tindak mencukupi!");
        }
        
    }

    
</script>