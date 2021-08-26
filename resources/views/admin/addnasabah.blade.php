
@extends('admin/template')
@section('content')
<!-- top tiles -->
                <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Input Data Nasabah</h3>
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
								<div class="x_title">
									<h2>Form Nasabah<small>Silahkan input datanya disini!</small></h2>
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
									<br />
									<form action="{{ $formAction }}" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                    {{ csrf_field() }}
										<div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Nomor Induk Nasabah</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="text" name="nin" value="{{ $nin }}" class="form-control" required placeholder="Nomor Induk Nasabah" {{ $readonly }} >
											</div>
										</div>
                                        <div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Nama Nasabah</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="text" name="nama" value="{{ $nama }}" class="form-control" placeholder="Nama Nasbah" required>
											</div>
										</div>
                                        <div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Jenis Kelamin</label>
                                            @php
                                            if($jk=="L")
                                                $l="checked";
                                            else
                                                $l="";
                                            

                                            if($jk=="P")
                                                $p="checked";
                                            else
                                                $p="";

                                            @endphp
											<div class="col-md-9 col-sm-9 ">
                                                <div class="radio">
													<label>
														<input type="radio" class="flat" name="jk" value="L" {{ $l }} required > Laki-Laki
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" class="flat" name="jk" value="P" {{ $p }} required > Perempuan
													</label>
												</div>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Nomor Kontak</label>
											<div class="col-md-9 col-sm-9 ">
                                                <input type="tel" name="nohp" value="{{ $nohp }}" class="form-control" id="inputSuccess5" placeholder="Phone" required>
                                                <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3 ">Alamat <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 ">
												<textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Nasabah">{{ $alamat }}</textarea>
											</div>
										</div>
                                        <div class="form-group row ">
											<label class="control-label col-md-3 col-sm-3 ">Username</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="text" class="form-control" name="username" placeholder="Username" value="{{ $username }}">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3 ">Password</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="password" class="form-control" name="password" placeholder="Silahkan diisi jika ingin ubah password!">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3 ">Foto</label>
											<div class="col-md-9 col-sm-9 ">
												@if(file_exists(public_path().'/foto/'.$foto) AND isset($foto))
													<img src="{{ asset('/foto/'.$foto) }}" width="150" height="200">
												@else
													<img src="{{ asset('/assets/admin/images/user.png') }}" width="150" height="200">
												@endif
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-3 col-sm-3 ">Upload Foto</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="file" class="form-control" name="image">
											</div>
										</div>
										<div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Kategori Nasabah
                                            </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select name="kategori" class="select2" onchange="cariData3(this.value)"  style="width: 100%;">
                                                    <option value=""></option>
                                                    <option value="siswa" {{ ($kategori=="siswa")?"selected":"" }}>Siswa</option>
                                                    <option value="umum" {{ ($kategori=="umum")?"selected":"" }}>Umum</option>
                                                </select>
                                            </div>
                                        </div>
										<?php
										if($kategori=="siswa"){
											$display="";
										}else{
											$display="display:none;";
										}
										?>
										<div class="form-group row " id="divNis" style="{{ $display }}">
											<label class="control-label col-md-3 col-sm-3 ">Nomor Induk Siswa</label>
											<div class="col-md-9 col-sm-9 ">
												<input type="text" class="form-control" name="nisn" placeholder="Nisn" value="{{ $nisn }}">
											</div>
										</div>
										<div class="form-group row" id="divThnmasuk" style="{{ $display }};">
                                            <label class="control-label col-md-3 col-sm-3 ">Tahun Masuk
                                            </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select name="thnmasuk" class="select2"  style="width: 100%;">
													@for($a=date('Y');$a>=2020;$a--)
														@if($thnmasuk==$a)
                                                    	<option value="{{ $a }}" selected>{{ $a }}</option>
														@else
														<option value="{{ $a }}">{{ $a }}</option>
														@endif
													@endfor
                                                </select>
                                            </div>
                                        </div>
										
										
										<div class="ln_solid"></div>
										<div class="form-group">
											<div class="col-md-9 col-sm-9  offset-md-3">
												<button type="reset" class="btn btn-primary">Reset</button>
												<button type="submit" class="btn btn-success">{{ $tombol }}</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
                    </div>
                </div>

@endsection

<script>
    function cariData3(x){

        if(x=='siswa'){
			document.getElementById('divNis').removeAttribute('style');
            document.getElementById('divThnmasuk').removeAttribute('style');
        }else{
			document.getElementById('divNis').style.display="none";
            document.getElementById('divThnmasuk').style.display="none";
			 
        }

    }
</script>