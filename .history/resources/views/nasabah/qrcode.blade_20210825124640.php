
@extends('nasabah/template')
@section('content')
<script src="{{ asset('assets/js/instascan.min.js') }}"></script>

<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper" style="background-color:#303030"> -->
    <section class="content" style="padding-left:0;padding-right:0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    sdfdsf
                {!! QrCode::size(200)->generate('W3Adda Laravel Tutorial'); !!}
                </div>
                    
            </div>
        </div>
    </section>
<!-- </diV> -->