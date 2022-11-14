<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <!-- Data Tables 
    <link href="{!! asset('css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/bootstrap-select.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.responsive.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/dataTables/dataTables.tableTools.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/animate.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/style.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/jquery-ui.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/plugins/datepicker/datepicker3.css') !!}" rel="stylesheet">
    
    -->
    <link href="{!! asset('css/all2.css') !!}" rel="stylesheet" media="screen">

<link href="{!! asset('font-awesome/css/font-awesome.css') !!}" rel="stylesheet"> <!-- Yang ini berhasil -->

    @yield('head')
</head>
<body>
    <div id="overlayd"></div>
    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            @if(\Auth::user()->role_id == '1')
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ \Storage::disk('s3')->url('img/dokter_pria.jpeg') }}" />
                            @elseif(\Auth::user()->role_id == '6')
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ \Storage::disk('s3')->url('img/profile_small.jpg') }}" />
                            @else
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ \Storage::disk('s3')->url('img/nurse.jpeg') }}" />
                            @endif
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                                {!! \Auth::user()->username !!}</strong>
                             </span> <span class="text-muted text-xs block">
                                
                                @if(\Auth::user()->role_id == '1')
                                    Dokter
                                @elseif(\Auth::user()->role_id == '2')
                                    Kasir
                                @elseif(\Auth::user()->role_id == '3')
                                    Bidan
                                @elseif(\Auth::user()->role_id == '4')
                                    Admin
                                @elseif(\Auth::user()->role_id == '5')
                                    Dokter Gigi
                                @elseif(\Auth::user()->role_id == '6')
                                    Super Admin
                                @endif

                             <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="{{ url('users/' . \Auth::id() . '/edit') }}">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('/logout')}}">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <li>
                        <a href="{{ url('laporans') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Data-data</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('pasiens', 'Pasien')!!}</li>
                            <li>{!! HTML::link('stafs', 'Staf')!!}</li>
                            <li>{!! HTML::link('asuransis', 'Asuransi')!!}</li>
                            <li>{!! HTML::link('suppliers', 'Supplier')!!}</li>
                            <li>{!! HTML::link('rumahsakits', 'Rumah Sakit')!!}</li>
                            <li>{!! HTML::link('tarifs', 'Tarif')!!}</li>
                            <li>{!! HTML::link('perujuks', 'Perujuk')!!}</li>
                            <li>{!! HTML::link('diagnosas', 'Diangosa')!!}</li>
                            <li>{!! HTML::link('users', 'User')!!}</li>
                            <li>{!! HTML::link('pembelians', 'Pembelian ')!!}</li>
                            <li>{!! HTML::link('fakturbelanjas/cari', 'Cari Faktur Belanja ')!!}</li>
                            <li>{!! HTML::link('bayardokters', 'Pembayaran Dokter')!!}</li>
                        </ul>
                    </li>
                    <li>
        
                        <a href="{{ url('antrianpolis') }}"><i class="fa fa-flask"></i> <span class="nav-label">Nurse Station</span> {!! App\Models\Classes\Yoga::jumlahDisini(App\AntrianPoli::orderBy('antrian', 'asc')->count()) !!} </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Poli</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ url('ruangperiksa/umum') }}">Poli Umum  {!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'umum')->orderBy('antrian', 'asc')->count())!!} </a> 
                            </li>
                            <li><a href="{{ url('ruangperiksa/anc') }}">Poli ANC {!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'anc')->orderBy('antrian', 'asc')->count())!!}</a> </li>
                            <li><a href="{{ url('ruangperiksa/suntikkb') }}">Suntik KB {!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', 'like', 'kb %')->orderBy('antrian', 'asc')->count())!!}</a> </li>


                            <li><a href="{{ url('ruangperiksa/usg') }}">Poli USG Kebidanan{!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'usg')->orderBy('antrian', 'asc')->count())!!}</a> </li>

                            <li><a href="{{ url('ruangperiksa/usgabdomen') }}">Poli USG Abdomen{!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'usgabdomen')->orderBy('antrian', 'asc')->count())!!}</a> </li>
                            

                            <li><a href="{{ url('ruangperiksa/gigi') }}">Poli Gigi {!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'gigi')->orderBy('antrian', 'asc')->count())!!}</a> </li>


                            <li><a href="{{ url('ruangperiksa/darurat') }}">Poli Gawat Darurat {!!App\Models\Classes\Yoga::jumlahDisini(App\AntrianPeriksa::where('poli', '=', 'darurat')->orderBy('antrian', 'asc')->count())!!}</a> </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('antriankasirs') }}"><i class="fa fa-flask"></i> <span class="nav-label">Antrian Apotek</span> {!! App\Models\Classes\Yoga::jumlahDisini(App\Periksa::where('lewat_kasir2', '0')->where('lewat_poli', '1')->count())!!} </a>
                    </li>
                     <li>
                        <a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Obat</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('mereks', 'Merek')!!}</li>
                            <li>{!! HTML::link('stokopnames', 'Stok Opname')!!}</li>
                            <li>{!! HTML::link('penjualans', 'Tanpa Resep')!!}</li>
                            <li>{!! HTML::link('obat/stokmin', 'Stok Minimal')!!}</li>
                            <li>{!! HTML::link('obat/pesanobat', 'Pesan Obat')!!}</li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('fakturbelanjas') }}"><i class="fa fa-flask"></i> <span class="nav-label">Antrian Belanja </span> {!! App\Models\Classes\Yoga::jumlahDisini(App\FakturBelanja::where('submit', '0')->count())!!} </a>
                    </li>
                    <li>
                        <a href="{{ url('diagnosa/tidakdirujuk') }}"><i class="fa fa-flask"></i> <span class="nav-label">Tidak Dirujuk </span> </a>
                    </li>
                    <li>
                        <a href="{{ url('pendapatans/create') }}"><i class="fa fa-flask"></i> <span class="nav-label">Pendapatan Lain </span> </a>
                    </li>
                     <li>
                        <a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Laporan Keuangan</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('jurnal_umums', 'Jurnal Umum')!!}</li>
                            <li>{!! HTML::link('buku_besars', 'Buku Besar')!!}</li>
                            <li>{!! HTML::link('neraca_saldos', 'Neraca Saldo')!!}</li>
                            <li>{!! HTML::link('laporan_laba_rugis', 'Laporan Laba Rugi')!!}</li>
                            <li>{!! HTML::link('laporan_arus_kass', 'Laporan Arus Kas')!!}</li>
                            <li>{!! HTML::link('laporan_neracas', 'Laporan Neraca')!!}</li>
                        </ul>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Transaksi Kasir</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('pendapatans/create', 'Pendapatan Lain')!!}</li>
                            <li>{!! HTML::link('pendapatans/pembayaran/asuransi', 'Pembayaran Asuransi')!!}</li>
                            <li>{!! HTML::link('suppliers/belanja_obat', 'Belanja Obat')!!}</li>
                            <li>{!! HTML::link('suppliers/belanja_bukan_obat', 'Belanja Bukan Obat')!!}</li>
                            <li>{!! HTML::link('pengeluarans/bayardoker', 'Bayar Dokter')!!}</li>
                            <li>{!! HTML::link('pengeluarans/nota_z', 'Nota Z')!!}</li>
                            <li>{!! HTML::link('pengeluarans/rc', 'RC')!!}</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Selamat Datang di {{ ucwords( \Auth::user()->tenant->name ) }}</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-exclamation-circle"></i>  <span class="label label-warning">{!! App\AntrianPoli::count() + App\AntrianPeriksa::count() + App\Periksa::where('lewat_kasir', '0')->get()->count()!!}</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-check-square-o"></i>  <span class="label label-primary">{!! App\Periksa::where('lewat_kasir2', '1')->where('tanggal', date('Y-m-d'))->get()->count() !!}</span>
                    </a>
                    </li>
        </nav>
        </div>
            <div class="row border-bottom white-bg page-heading">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    @yield('page-title')
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                    <div class="wrapper wrapper-content animated fadeInRight">
                        @if (Session::has('pesan'))
                            {!! Session::get('pesan')!!}
                        @endif
                        @yield('content')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                @if (count($errors) > 0)
                                  <div class="alert alert-danger">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{!! $error !!}</li>
                                        @endforeach
                                    </ul>
                                  </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
            {!! HTML::script("js/all2.js")!!}

    <!-- Mainly scripts 
    <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
    <script src="{!! url('js/bootstrap.min.js') !!}"></script>
    <script src="{!! url('js/plugins/metisMenu/jquery.metisMenu.js') !!}"></script>
    <script src="{!! url('js/plugins/slimscroll/jquery.slimscroll.min.js') !!}"></script>
    <script src="{!! url('js/plugins/jeditable/jquery.jeditable.js') !!}"></script>
    <script src="{!! url('js/bootstrap-select.min.js') !!}"></script>
    <script src="{!! url('js/plugins/datepicker/bootstrap-datepicker.js') !!}" type="text/javascript"></script>
    <script src="{!! url('js/plugins/dataTables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! url('js/plugins/dataTables/dataTables.bootstrap.min.js') !!}"></script>
    <script src="{!! url('js/plugins/dataTables/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! url('js/inspinia.js') !!}"></script>
    <script src="{!! url('js/plugins/pace/pace.min.js') !!}"></script>
    WebCam -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {


            $('.uangInput').autoNumeric('init', {
                aSep: '.',
                aDec: ',', 
                aSign: 'Rp. ',
                vMin: 0,
                mDec: 0
            });

            formatUang();
            
            $('.jumlah').each(function() {
                var number = $(this).html();
                number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
                $(this).html(number);
            });

        //plug in datetimepicker waktu bebas terserah

            $('.tanggal').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'dd-mm-yyyy'
            });

            $('.bulanTahun').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'mm-yyyy',
                minViewMode: 'months'
            });

//            $('.DT').dataTable({
//                responsive: true,
//                "dom": 'T<"clear">lfrtip',
//                "bSort" : false,
//                "tableTools": {
//                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
//                }
//            });
            $('.DT').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "bSort" : false
            });
            $('.DTi').dataTable({
                "aaSorting": [[ 6, "desc" ]],
                "responsive" : true,
                "dom": 'T<"clear">lfrtip',
                // "bSort" : false,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });
            /* Init DataTables */
            var oTable = $('#editable').dataTable();
            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },
                "width": "90%",
                "height": "100%"
            });
        });
      function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );
        }




    </script>
<style>
    body.DTTT_Print {
        background: #fff;
    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
        @yield('footer')
</body>
</html>

