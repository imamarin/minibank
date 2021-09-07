@extends('admin/template')
@section('content')
<!-- top tiles -->
<div class="row" >
          <div class="tile_count col-md-12">
            <div class="row">
              <div class="col-md-3 col-sm-3  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Nasabah</span>
                <div class="count blue">{{ isset($nasabah)?$nasabah:'0' }}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-plus"></i> {{ $addnasabah }} </i> Hari ini</span>
              </div>
              <div class="col-md-3 col-sm-3  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Nasabah Aktif</span>
                <div class="count blue">{{ isset($nasabahaktif)?$nasabahaktif:'0' }}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-plus"></i> {{ $addnasabah }} </i> Hari ini</span>
              </div>
              <div class="col-md-3 col-sm-3  tile_stats_count">
                <span class="count_top"><i class="fa fa-money"></i> Total Tabungan</span>
                <div class="count green">{{ number_format($tabungan->setor - $tabungan->tarik,0,'.',',') }}</div>
                <span class="count_bottom"><i class="green"><i class="fa fa-plus"></i> {{ number_format($addtabungan->setor,0,'.',',') }}</i> Hari ini</span>
              </div>
              <div class="col-md-3 col-sm-3  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>Total Transaksi</span>
                <div class="count">{{ isset($transaksi)?$transaksi:'0' }}</div>
                <span class="count_bottom"><i class="green"> Hari ini</span>
              </div>
            </div>  

          </div>
        </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Transaksi Harian<small></small></h3>
                  </div>
                  
                 <!-- <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>  -->
                </div>
                <script>
                 
                </script>
                <div class="col-md-9 col-sm-9 ">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
                </div>
                <div class="col-md-3 col-sm-3  bg-white">
                  <div class="x_title">
                    <h2>Transaksi Bulan Ini</h2>
                    <?php
                      $total = $setor->nom+$tarik->nom;
                    ?>
                    <div class="clearfix"></div>
                  </div>

                  <div class="col-md-12 col-sm-12 ">
                    <div>
                      <p>Setoran - Rp. {{ number_format($setor->nom,0,",",".") }}</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <?php
                            $s = $setor->nom/$total*100;
                          ?>
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $s }}"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Penarikan - Rp. {{ number_format($tarik->nom,0,",",".") }}</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                        <?php
                            $t =  $tarik->nom/$total*100;
                          ?>
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="{{ $t }}"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-md-12 col-sm-12 ">
                    <div>
                      <p>Conventional Media</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Bill boards</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </div>
                    </div>
                  </div> -->

                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />
@endsection