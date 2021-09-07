
@extends('admin/template')
@section('content')
<!-- top tiles -->
                <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Input Data Tagihan</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									
								</div>
							</div>
						</div>
					</div>
                    <div class="clearfix"></div>
                    <div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">

								<div class="x_content">
									<br />
									<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jenis Tagihan
											</label>
											<div class="col-md-6 col-sm-6 ">      
                                                <input type="radio" class="flat" name="jenis" value="true"/>Open Payment
                                                <input type="radio" class="flat" name="jenis"  value="false" /> Close Payment
                                            
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Akumulasi Tagihan 											</label>
											<div class="col-md-6 col-sm-6 ">
                                                <label></label>
                                                <input type="checkbox" id="akumulasi" name="akumulasi" value="1" required class="flat" />
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Tanggal tagihan
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="date" id="tglTagihan" name="tglTagihan" value="{{ $tgl }}" required="required" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Nomor Pembayaran</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="nomor" class="form-control" type="number" name="nomor">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nomor Urut
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="number" id="urut" name="urut" required="required" class="form-control">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Tanggal Berlaku
											</label>
											<div class="col-md-4 col-sm-4 ">
												<input type="datetime-local" id="tanggal1" name="tanggal1" value="{{ str_replace(' ','T',date('Y-m-d H:i', strtotime($waktuawal))) }}" required="required" class="form-control">
											</div>
                                            <div class="col-md-4 col-sm-4 ">
												<input type="datetime-local" id="tanggal2" name="tanggal2" value="{{ str_replace(' ','T',date('Y-m-d H:i', strtotime($waktuakhir))) }}" required="required" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">VA
											</label>
											<div class="col-md-6 col-sm-6 ">
												
													@if(isset($norek))
														<input type="text" id="va" name="va" required="required" value="{{ $norek }}" readonly class="form-control">
                                                    @else
													<select name="va" id="va" class="select2"  style="width: 100%;" onchange="getNasabah(this.value)">
														<option value="">Pilih Nasabah</option>
														@foreach($rekening as $row)
																<option value="{{ $row->norek }}">{{ $row->norek." | ".$row->nama}}</option>																
														@endforeach
													</select>
													@endif
                                                
												
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama
											</label>
											<div class="col-md-6 col-sm-6 ">
											<input type="text" id="name" name="name" required="required" value="{{ $nama }}" readonly class="form-control">
												<!-- <select name="name" class="select2"  style="width: 100%;">
                                                    <option value="">Pilih Nasabah</option>
                                                    @foreach($rekening as $row)
                                                    <option value="{{ $row->nama }}">{{ $row->nin." | ".$row->nama}}</option>
                                                    @endforeach
                                                </select> -->
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Email
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="email" id="email" name="email" value="{{ $email }}" readonly class="form-control">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Handphone
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="hp" name="hp" value="{{ $nohp }}" readonly class="form-control">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Alamat
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="alamat" name="alamat" readonly class="form-control">{{ $alamat }}</textarea>
											</div>
										</div>
										<div class="ln_solid"></div>
                                        <b>Rincian Tagihan</b><br><br>
										@if(empty($norek))
											<div class="row" id="divTagihan0">
												
												<div class="col-md-4 col-sm-4">
													<label>Deksripsi</label>
													<input type="text" id="deskripsi[0]" name="deskripsi" value="" class="form-control" name="fullname" required />
												</div>
												<div class="col-md-3 col-sm-3">
													<label>Nominal</label>
													<input type="text" id="unitPrice[0]" name="unitPrice[0]" value="" class="form-control" name="fullname" required />
												</div>
												<div class="col-md-2 col-sm-2">
													<label>Quantity</label>
													<input type="text" id="qty[0]" name="qty[0]" class="form-control" value="" name="fullname" required onkeyup="subNominal(0)"/>
												</div>
												<div class="col-md-3 col-sm-3">
													<label>Total Nominal </label>
													<input type="text" id="subnominal[0]" name="subnominal[0]" value="0" readonly class="form-control" name="fullname" required />
												</div>
											</div>
										@else
											@foreach($detail as $k=>$v)
											<div class="row" id="divTagihan0">
												
												<div class="col-md-4 col-sm-4">
													<label>Deksripsi</label>
													<input type="text" id="deskripsi[{{ $k }}]" name="deskripsi" value="{{ $v->kode_jenis_biaya }}" class="form-control" name="fullname" required />
												</div>
												<div class="col-md-3 col-sm-3">
													<label>Nominal</label>
													<input type="text" id="unitPrice[{{ $k }}]" name="unitPrice[{{ $k }}]" value="{{ $v->nilai_tagihan }}" class="form-control" name="fullname" required />
												</div>
												<div class="col-md-2 col-sm-2">
													<label>Quantity</label>
													<input type="text" id="qty[{{ $k }}]" name="qty[{{ $k }}]" class="form-control" value="{{ $v->qty }}" name="fullname" required onkeyup="subNominal({{ $k }})"/>
												</div>
												<div class="col-md-3 col-sm-3">
													<label>Total Nominal </label>
													<input type="text" id="subnominal[{{ $k }}]" name="subnominal[{{ $k }}]" readonly value="{{ $v->qty * $v->nilai_tagihan }}" class="form-control" name="fullname" required />
												</div>
											</div>
											@endforeach
										@endif
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <br>
                                                <button type="button" class="btn col-12 text-black border-primary" onclick="addRincian()"> Tambah Rincian </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9 col-sm-9 text-md-right text-sm-right text-right">
                                                <br>
                                                TOTAL NOMINAL 
                                            </div>
                                            <div class="col-md-3 col-sm-3 text-md-right text-sm-right text-right">
                                                <br>
                                                <input type="text" id="totalnominal" name="totalnominal" readonly class="form-control" required /> 
                                            </div>
                                        </div>



										<div class="item form-group">
											<div class="col-md-6 col-sm-6">
												<button type="button" class="btn btn-primary" type="button" onclick="{{ $onclick }}">Buat Tagihan</button>
												<button class="btn btn-warning" type="reset">Reset</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
<script>
console.log(document.getElementById('tanggal1').value)
var n=0;
function addRincian(){
	n = n+1;
	k = n-1;
	console.log(n)
	var node = document.getElementById("divTagihan"+k);
	node.insertAdjacentHTML("afterend",'<br><div class="row" id="divTagihan'+n+'"><div class="col-md-4 col-sm-4"><input type="text" id="deskripsi['+n+']" name="deskripsi" class="form-control" name="fullname" value="" /></div><div class="col-md-3 col-sm-3"><input type="text" id="unitPrice['+n+']" name="unitPrice['+n+']" class="form-control" name="fullname" required /></div><div class="col-md-2 col-sm-2"><input type="text" id="qty['+n+']" name="qty['+n+']" onkeyup="subNominal('+n+')" class="form-control" name="fullname" required /></div><div class="col-md-3 col-sm-3"><input type="text" id="subnominal['+n+']" name="subnominal['+n+']" class="form-control" name="fullname" required /></div></div>');
	// alert("sda");
}		
		
function simpanTagihan(){
    alert(document.getElementById('totalnominal').value);
    var desk = document.getElementsByName('deskripsi');
    var deskripsi= new Array();
    var json = [];
    for (const [key, row] of desk.entries()){
        deskripsi[key] = row.value;
        var subArray = deskripsi[key], item = {
                description: row.value,
                unitPrice: document.getElementById('unitPrice['+key+']').value,
                qty: document.getElementById('qty['+key+']').value,
                amount: document.getElementById('subnominal['+key+']').value
            };
        json.push(item); 
    }

    // var jenis = document.forms[0];
    // var i;
    // var txt = "false";
    // for (i = 0; i < jenis.length; i++) {
    //     if (jenis[i].checked) {
    //     txt = jenis[i].value;
    //     }
    // }
    console.log(JSON.stringify(json))
    // $.post( '{{ url("tagihan/lokal") }}' ,{
    //             '_token': $('meta[name=csrf-token]').attr('content'),
    //             id_record_tagihan: "33333",
    //             nomor_pembayaran: "8808",
    //             nama: document.getElementById('name').value,
    //             is_tagihan_aktif: 1,
    //             urutan_antrian: 0,
    //             total_nilai_tagihan: document.getElementById('totalnominal').value,
    //             nomor_induk: document.getElementById('va').value,
	// 			waktu: document.getElementById('tglTagihan').value,
	// 			waktuaktif: formatDate(document.getElementById('tanggal1').value),
	// 			waktuakhir: formatDate(document.getElementById('tanggal2').value),
    //             deskripsi: JSON.stringify(json),
    //             pembayaran_atau_voucher: "PEMBAYARAN",
    //         }, function(data, sukses){
    //             console.log(data)
    //         });

    $.ajax(
          {
            method: "POST",
            url: "https://billing-bpi.maja.id/api/v2/register",
            crossDomain: true,
            data: JSON.stringify({
                // "va": "880812345001",
                // "invoiceNumber": 18996,
                // "amount": 30000
                // "date": "2021-09-06",
                // "amount": 0,
                // "name": "TEGUH NADIANA",
                // "email": "-",
                // "address": "Tasikmalaya",
                // // "activeDate": formatDate(document.getElementById('tanggal1').value),
                // // "inactiveDate": formatDate(document.getElementById('tanggal2').value),
                // // "address": formatDate(document.getElementById('alamat').value),
                "va": "201904004",
                "openPayment" : true,
                // "number":"TAB/2021",
                "items": json,

                "date": document.getElementById('tglTagihan').value,
                "amount": 0,
                "name": document.getElementById('name').value,
                "email": document.getElementById('email').value,
                "address": document.getElementById('alamat').value,
                // // // "activeDate": formatDate(document.getElementById('tanggal1').value),
                // // // "inactiveDate": formatDate(document.getElementById('tanggal2').value),
                // // "address": formatDate(document.getElementById('alamat').value),
                // "va": document.getElementById('va').value,
                // "openPayment" : 'true',
                // "items": json,
                
                    // [{
                    //     "description": document.getElementById('deskripsi').value,
                    //     "unitPrice": document.getElementById('unitPrice').value,
                    //     "qty": document.getElementById('qty').value,
                    //     "amount": document.getElementById('subnominal').value
                    // }],

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
            if(hasil.code=="00"){
                $.post( '{{ url("tagihan/lokal") }}' ,{
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    id_record_tagihan: dt.number,
                    nomor_pembayaran: dt.va,
                    nama: dt.name,
                    is_tagihan_aktif: 1,
                    urutan_antrian: 0,
                    total_nilai_tagihan: dt.amount,
                    nomor_induk: dt.va,
                    waktu: dt.date,
                    waktuaktif: dt.activeDate,
                    waktuakhir: dt.inactiveDate,
                    deskripsi: JSON.stringify(json),
                    pembayaran_atau_voucher: "PEMBAYARAN",
                }, function(data, sukses){
                    console.log(data)
                });
            }

    });
    // $('#modal').modal('hide');
}

function updateTagihan(){
    var desk = document.getElementsByName('deskripsi');
    var deskripsi= new Array();
    var json = [];
    for (const [key, row] of desk.entries()){
        deskripsi[key] = row.value;
        var subArray = deskripsi[key], item = {
                description: row.value,
                unitPrice: document.getElementById('unitPrice['+key+']').value,
                qty: document.getElementById('qty['+key+']').value,
                amount: document.getElementById('subnominal['+key+']').value
            };
        json.push(item); 
    }

	$.ajax(
          {
            method: "POST",
            url: "https://billing-bpi.maja.id/api/v2/update/{{ $id }}",
            crossDomain: true,
            data: JSON.stringify({
                // "va": "880812345001",
                // "invoiceNumber": 18996,
                // "amount": 30000
                "date": document.getElementById('tglTagihan').value,
                "amount": document.getElementById('totalnominal').value,
                "name": document.getElementById('name').value,
                "email": document.getElementById('email').value,
                "address": document.getElementById('alamat').value,
				"activeDate": formatDate(document.getElementById('tanggal1').value),
                "inactiveDate": formatDate(document.getElementById('tanggal2').value),
                "va": document.getElementById('va').value,
                "items":json,
                // "items":[{"description":"SPP","unitPrice":"200000","qty":"1","amount":"200000"}],

                "attributes": []
              }),
            headers:{ 
              'Authorization': 'Bearer {{ $token }}',
              'Content-Type': 'application/json'
            },
            
            success: function(result){
                console.log(result);
            },
            error: function(error){
                console.log(error)
            }
        }).done(function(obj){
            var xhttp = new XMLHttpRequest();
            var hasil = JSON.parse(JSON.stringify(obj));
            var dt = hasil.data
            if(hasil.code=="00"){
                $.post( '{{ url("tagihan/update") }}' ,{
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    id_record_tagihan: dt.number,
                    nomor_pembayaran: dt.va,
                    nama: dt.name,
                    is_tagihan_aktif: 1,
                    urutan_antrian: 0,
                    total_nilai_tagihan: dt.amount,
                    nomor_induk: dt.va,
                    waktu: dt.date,
                    waktuaktif: dt.activeDate,
                    waktuakhir: dt.inactiveDate,
                    deskripsi: JSON.stringify(json),
                    pembayaran_atau_voucher: "PEMBAYARAN",
                }, function(data, sukses){
                    console.log(data)
                });
            }
            // console.log(hasil.data)
            // obj.data.forEach(function(value,index){
            //     document.getElementById('hasil').innerHTML +=value.code
            // });
            // xhttp.open("GET", hasil, true);
            // xhttp.send();

            //document.getElementById('hasil').innerHTML = hasil;
    });
}

function getNasabah(x){
    console.log(x);
	$.post("{{ route('nasabah.cari') }}", 
            {   
                '_token': $('meta[name=csrf-token]').attr('content'),
                norek: x
            }, 
            function(data, status){
                document.getElementById('name').value=data.nama;
                document.getElementById('email').value=data.email;
                document.getElementById('hp').value=data.hp;
                document.getElementById('alamat').value=data.alamat;
        });
}

var nominal=[];
totalNominal();
function subNominal(z){
    // console.log(z)
	var x = document.getElementById('unitPrice['+z+']').value;
	var y = document.getElementById('qty['+z+']').value;
	nominal[z] = x * y;
	document.getElementById('subnominal['+z+']').value = nominal[z];

    // total = 0;
    // for (var i = 0; i < nominal.length; i++) {
    //     total = total + nominal[i]
    //     console.log(nominal[i])
    // }
    // console.log(nominal.length)
	
    totalNominal()
}

function totalNominal(){
    var desk = document.getElementsByName('deskripsi');
    var deskripsi= new Array();
    var json = [];   
    var total=0;
    for (const [key, row] of desk.entries()){
        total = total + parseInt(document.getElementById('subnominal['+key+']').value)
    }
    document.getElementById('totalnominal').value = total;
}

function formatDate(date) {
  tgl = date.split("T");
  waktu = tgl[0]+" "+tgl[1]+":00";
  return waktu;
}

</script>

@endsection
