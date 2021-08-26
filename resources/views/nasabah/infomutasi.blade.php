@extends('nasabah/template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<script>
    if ( window.history.replaceState ) {
        lokasi = "{{ url('nasabah/home') }}";
        window.history.replaceState( null, null, lokasi);
    }
</script>

<div class="content-wrapper"style="margin-bottom:0px;">
    <section class="content" style="padding-left:0;padding-right:0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3" style="margin-bottom:100px;">
                    <br>
                    <div class="card card-cyan card-outline">
                        <div class="card-body box-profile">

                            <h3 class="profile-username text-center">INFORMASI MUTASI</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                @foreach($transaksi as $data)
                                <li class="list-group-item">
                                    <b>Waktu Transaksi</b><a class="float-right">{{ $data->waktu }}</a><br>
                                    Nominal: {{ $data->nominal }}<br>
                                    Jenis Transaksi: {{ $data->jnstransaksi }}<br>
                                    @if($data->jnstransaksi=='transfer')
                                        @if($data->norektujuan==$norek)
                                            Dari Rekening: {{ $data->norek }} ({{ $data->nama }})<br>
                                        @else
                                            Tujuan Rekening: {{ $data->norektujuan }} ({{ $data->penerima }})<br>
                                        @endif
                                        @if($data->idsubrekening!='-')
                                            Sub Rekening: {{ $data->subrekening }}<br>
                                            Ket: {{ $data->keterangan }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


