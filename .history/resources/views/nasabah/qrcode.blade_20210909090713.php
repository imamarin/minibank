
@extends('nasabah/template')
@section('content')

<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" style="background-color:#303030"> -->
    <section class="content" style="padding-left:0;padding-right:0;margin-top:150px;text-align:center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                {!! QrCode::size(300)->generate(session()->get('norek')); !!}
                </div>
                <div class="col-md-12 m-3 font-weight-bold" style="text-align:center">SCAN ME</div>
                    
            </div>
        </div>
    </section>
<!-- </diV> -->
@endsection