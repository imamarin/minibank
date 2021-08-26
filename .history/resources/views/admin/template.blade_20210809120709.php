<!DOCTYPE html>

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ Session::token() }}">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Admin | Minibank</title>

    <!-- Bootstrap -->
    <link href="{{ asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('/assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('/assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('/assets/admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('/assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('/assets/admin/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('/assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Datatables -->
    
    <link href="{{ asset('/assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('/assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
    <style>
      .btn{
        font-size:12px;
      }

      .printArea{
            display: none;
      }
    </style>
  </head> 

  <body class="nav-md" onload="autodebet()">
    <div class="printArea">
sss
    </div>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ url('home') }}" class="site_title"><i class="fa fa-bank"></i> <span>Mini Bank YPC</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
              @if(file_exists(public_path().'/foto/'.session()->get('induk').'.jpg') || file_exists(public_path().'/foto/'.session()->get('induk').'.png'))
                <img src="{{ asset('/foto/'.session()->get('foto')) }}" alt="..." class="img-circle profile_img" height='55'>
              @else
                <img src="{{ asset('/assets/admin/images/user.png') }}" alt="..." class="img-circle profile_img">
              @endif
              </div>
              <div class="profile_info">
                <span>Selamat Datang,</span>
                <h2>{{ session()->get('nama') }}</h2>

              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu Navigasi</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-clone"></i> Data Master<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('nasabah') }}">Nasabah</a></li>
                      <li><a href="{{ url('rekening') }}">Rekening</a></li>
                      <li><a href="{{ url('pegawai') }}">Pegawai</a></li>
                      <li><a href="{{ url('autodebet') }}">Auto Debet</a></li>

                    </ul>
                  </li>
                  <li><a><i class="fa fa-credit-card"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('tabungan') }}">Setor / Tarik</a></li>
                      <li><a href="{{ url('transfer') }}">Transfer</a></li>
                      <li><a href="{{ url('printtabungan') }}">Cetak Buku Tabungan</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-file"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('laporantransaksi') }}">Lap. Transaksi</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
              </a>

            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  @if(file_exists(public_path().'/foto/'.session()->get('induk').'.jpg') || file_exists(public_path().'/foto/'.session()->get('induk').'.png'))
                    <img src="{{ asset('/foto/'.session()->get('foto')) }}" alt="">
                  @else
                    <img src="{{ asset('/assets/admin/images/user.png') }}">
                  @endif
                    {{ session()->get('username') }}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    <a class="dropdown-item"  href="{{ '/logout' }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>
                <?php
                  $notif = DB::table('notif');
                ?>
                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?= $notif->count() ?></span>
                  </a>
                  
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    @foreach($notif->get() AS $val)
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <!-- <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span> -->
                        <span>
                          <span>{{$val->va}}</span>
                          <span class="time">{{$val->timenotif}}</span>
                        </span>
                        <span class="message">
                          {{$val->message}}
                        </span>
                      </a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>Lihat Semua</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
        <?php
          
        ?>

          @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            TIM IT <a href="https://web.smk-ypc.sch.id">SMK YPC Tasikmalaya</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/assets/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('/assets/admin/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('/assets/admin/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('/assets/admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('/assets/admin/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('/assets/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('/assets/admin/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('/assets/admin/vendors/skycons/skycons.js') }}"></script>
    <!-- Switchery -->
	  <script src="{{ asset('/assets/admin/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('/assets/admin/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('/assets/admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('/assets/admin/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('/assets/admin/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('/assets/admin/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
     <!-- Datatables -->
    <script src="{{ asset('/assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/vendors/pdfmake/build/vfs_fonts.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('/assets/admin/build/js/custom.min.js') }}"></script>

    <script src="{{ asset('/assets/admin/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
          $(function () {
          //Initialize Select2 Elements
            $('.select2').select2()
          });
    </script>

    <script>
      function autodebet(){
        setInterval(function(){ 
          $.get("{{ route('autodebet.proses') }}", 
            {   
                
            }, 
            function(data,success){
              

          });
        }, 60000);
      }
    </script>
	
  </body>
</html>
