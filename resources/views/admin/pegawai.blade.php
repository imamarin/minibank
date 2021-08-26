@extends('admin/template')
@section('content')
<!-- top tiles -->
    <div class="">
                    <div class="page-title">
						<div class="title_left">
							<h3>Data Pegawai</h3>
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
                        <a href="{{ url('pegawai/input') }}"><button class="btn btn-primary">Tambah Data</button></a>
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
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Induk Pegawai</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No HP</th>
                                            <th>Alamat</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach($pegawai as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->nip }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->jk }}</td>
                                            <td>{{ $data->nohp }}</td>
                                            <td>{{ $data->alamat }}</td>
                                            <th>
                                            <a href="{{ url('pegawai/edit',['id'=>$data->nip]) }}"><button class="btn btn-info">Edit</button></a>
                                            <a href="{{ url('pegawai/hapus',['id'=>$data->iduser]) }}" onclick="return confirm('Hapus Data ini?')"><button class="btn btn-danger">Hapus</button></a>
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


@endsection
