@extends('admin/template')
@section('content')
<!-- top tiles -->
<script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Data Tagihan</h3>
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
                        
                        <!-- <button type="button" class="btn btn-primary" name="inputmodal" data-toggle="modal" data-target=".bs-example-modal-lg">Input Data Tagihan</button> -->
                        <a href="{{ url('tagihan/add') }}" class="btn btn-primary">Input Data Tagihan</a>
                        
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
                                <div class="card-box table-responsive" id="hasil">
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"  cellspacing="0" width="100%">
                                        <thead>
                                            <tr style="font-size:12px">
                                                <th>No</th>
                                                <th>Nomor Tagihan</th>
                                                <th>Virtual Account</th>
                                                <th>Konsumen</th>
                                                <th>Nominal</th>
                                                <th>Urutan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach($tagihan as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $data->nomor_pembayaran }}</td>
                                                    <td>{{ $data->nomor_induk }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                    <td>{{ $data->total_nilai_tagihan }}</td>
                                                    <td>{{ $data->urutan_antrian }}</td>
                                                    <td>
                                                        <a href="#" onclick="batal('{{ $data->nomor_induk }}','{{ $data->nomor_pembayaran }}','{{ $data->total_nilai_tagihan }}')" class="btn btn-danger">Batalkan</a> 
                                                        <a href="#" onclick="inquiry('{{ $data->nomor_induk }}','{{ $data->nomor_pembayaran }}','{{ $data->total_nilai_tagihan }}')" class="btn btn-info">Cek Tagihan</a>
                                                        <a href="{{ url('tagihan/edit',['id'=>$data->nomor_pembayaran])  }}" class="btn btn-primary">Edit tangihan</a>
                                                    </td>

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

<div class="modal fade bs-example-modal-lg" id="modal" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form action="#" method="post" name="formData" class="form-horizontal form-label-left">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Request Invoice</h4>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="control-label col-md-3 col-sm-3 ">Nama Nasabah
                                                </label>
                                                <div class="col-md-9 col-sm-9 ">
                                                <input type="text" name="nama" id="name" value="Andari" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">Email</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="email" id="email" value="andari@sebuahdomain.com" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">va</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="va" id="va" value="880812345001" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">Deskripsi</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="deskripsi" id="deskripsi" value="SPP" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">unitPrice</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="unitPrice" id="unitPrice" value="175000" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">Qty</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="qty" id="qty" value="1" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">Amount</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="amount" id="amount" value="175000" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3 col-sm-3 ">Alamat</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="alamat" id="alamat" value="Tasikmalaya" class="form-control" required placeholder="PIN">
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" id="btn" class="btn btn-primary" onclick="tagihan()">SIMPAN</button>
                                    </div>
                                </form>     
                                </div>
                            </div>
                        </div>


<script>
function tagihan(){
    $.ajax(
          {
            method: "POST",
            url: "https://billing-bpi.maja.id/api/v2/register",
            crossDomain: true,
            data: JSON.stringify({
                // "va": "880812345001",
                // "invoiceNumber": 18996,
                // "amount": 30000
                "date": {{ date('Y-m-d') }},
                "amount": document.getElementById('amount').value,
                "name": document.getElementById('name').value,
                "email": document.getElementById('email').value,
                "address": document.getElementById('alamat').value,
                "va": document.getElementById('va').value,
                "items": 
                    [{
                        "description": document.getElementById('deskripsi').value,
                        "unitPrice": document.getElementById('unitPrice').value,
                        "qty": document.getElementById('qty').value,
                        "amount": document.getElementById('amount').value
                    }],

                "attributes": []
              }),
            headers:{ 
              'Authorization': 'Bearer {{ $token }}',
              'Content-Type': 'application/json'
            },
            
            success: function(result){
                console.log(result);
                //hasil = JSON.parse(result);
                //document.getElementById('hasil').innerHTML = result.data;
                //alert("Bearer <{{ $token }}>")
            },
            error: function(error){
                console.log(error)
            }
        }).done(function(obj){
            // var xhttp = new XMLHttpRequest();
            var hasil = JSON.parse(JSON.stringify(obj));
            var dt = hasil.data
            if(hasil.code=='00'){
                $.post( '{{ url("tagihan/lokal") }}' ,{
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    id_record_tagihan: dt.number,
                    nomor_pembayaran: dt.va,
                    nama: dt.name,
                    is_tagihan_aktif: 1,
                    urutan_antrian: 0,
                    total_nilai_tagihan: dt.amount,
                    nomor_induk: dt.va,
                    deskripsi: document.getElementById('deskripsi').value,
                    qty: document.getElementById('deskripsi').value,
                    pembayaran_atau_voucher: "PEMBAYARAN",
                }, function(data, sukses){
                    console.log(data)
                });
            }
            
            console.log(dt.number);
            console.log(dt.amount);
            console.log(dt.name);
            console.log(dt.va);
            // console.log(hasil.data)
            // obj.data.forEach(function(value,index){
            //     document.getElementById('hasil').innerHTML +=value.code
            // });
            // xhttp.open("GET", hasil, true);
            // xhttp.send();

            //document.getElementById('hasil').innerHTML = hasil;
    });
    $('#modal').modal('hide');
}

function batal(x,y,z){
    // console.log(x)
    // console.log(y)
    // console.log(z)
    $.ajax(
          {
            method: "POST",
            // url: "https://billing-bpi-dev.maja.id/api/v2/cancel",
            url: "https://billing-bpi.maja.id/api/v2/cancel",
            crossDomain: true,
            data: JSON.stringify({
                '_token': $('meta[name=csrf-token]').attr('content'),
                va: x,
                invoiceNumber: y,
                amount: z
            }),
            headers:{ 
                'Authorization': 'Bearer {{ $token }}',
                'Content-Type': 'application/json'
            },
            
            success: function(result){
                var hasil = JSON.parse(JSON.stringify(result));
                var dt = hasil
                console.log(result);
                if(hasil.code == 00){
                    $.post( '{{ url("tagihan/batal") }}' ,{
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        va: x,
                        invoiceNumber: y,
                    }, function(data, sukses){
                        console.log(data)
                    });
                }
                
            },
            error: function(error){
                console.log(error)
            }
        }).done(function(obj){
            
    });
}

function inquiry(x,y,z){
    // console.log(x)
    // console.log(y)
    // console.log(z)
    $.ajax(
          {
            method: "POST",
            url: "https://billing-bpi.maja.id/api/v2/inquiry",
            crossDomain: true,
            data: JSON.stringify({
                '_token': $('meta[name=csrf-token]').attr('content'),
                va: 880812345001,
                invoiceNumber: y,
                amount: z
            }),
            headers:{ 
                'Authorization': 'Bearer {{ $token }}',
                'Content-Type': 'application/json'
            },
            
            success: function(result){
                var hasil = JSON.parse(JSON.stringify(result));
                var dt = hasil
                console.log(result);
                
            },
            error: function(error){
                console.log(error)
            }
        }).done(function(obj){
            
    });
}
</script>


                
@endsection


