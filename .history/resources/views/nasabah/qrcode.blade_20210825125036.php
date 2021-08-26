
@extends('nasabah/template')
@section('content')

<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" style="background-color:#303030"> -->
    <section class="content" style="padding-left:0;padding-right:0;margin-top:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                {!! QrCode::size(200)->generate('W3Adda Laravel Tutorial'); !!}
                </div>
                    
            </div>
        </div>
    </section>
<!-- </diV> -->
@endsection