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
    <link href="{!! asset('css/all.css') !!}" rel="stylesheet" media="screen">

<link href="{!! asset('font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">
	<style type="text/css" media="all">
		.fixed {
			position: fixed;
			bottom: -20px;
			right: 0px;
			z-index: 999;
		}

		.full {
			width:100% !important;
		}
	</style>

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
                            @if(\Auth::user()->role == '1')
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ url('img/dokter_pria.jpeg') }}" />
                            @elseif(\Auth::user()->role == '6')
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ url('img/profile_small.jpg') }}" />
                            @else
                                <img alt="image" class="img-circle" width="75px" height="75px" src="{{ url('img/nurse.jpeg') }}" />
                            @endif
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                                {!! \Auth::user()->username !!}</strong>
                             </span> <span class="text-muted text-xs block">
                                

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
                        <a href="{{ url('facebook/list') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Pendaftaran Online</span></a>
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
                            <li>{!! HTML::link('pengeluarans/peralatans', 'Peralatan')!!}</li>
                            <li>{!! HTML::link('users', 'User')!!}</li>
                            <li>{!! HTML::link('diagnosa/tidakdirujuk', 'Tidak Dirujuk')!!}</li>
                            <li>{!! HTML::link('prolanis', 'Prolanis')!!}</li>
                            <li>{!! HTML::link('prolanis/terdaftar', 'Prolanis Terdaftar')!!}</li>
                            <li>{!! HTML::link('discounts', 'Discount')!!}</li>
                            <li>{!! HTML::link('acs', 'Air Conditioner')!!}</li>
                            <li>{!! HTML::link('pasiens/gabungkan/pasien/ganda', 'Gabungkan Pasien Dobel')!!}</li>
                            <li>{!! HTML::link('pelamars', 'Data Pelamar')!!}</li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Data Transaksi</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('pembelians', 'Pembelian ')!!}</li>
                            <li>{!! HTML::link('fakturbelanjas/obat', 'Faktur Belanja Obat')!!}</li>
                            <li>{!! HTML::link('fakturbelanjas/alat', 'Faktur Belanja Peralatan')!!}</li>
                            <li>{!! HTML::link('pengeluarans/data', 'Faktur Belanja Bukan Obat')!!}</li>
                            <li>{!! HTML::link('fakturbelanjas/serviceAc', 'Faktur Service Ac')!!}</li>
                            <li>{!! HTML::link('nota_juals', 'Cari Nota Jual ')!!}</li>
                            <li>{!! HTML::link('bayardokters', 'Pembayaran Dokter')!!}</li>
                            <li>{!! HTML::link('promo/kecantikan/ktp/pertahun', 'Promo KTP Per Tahun')!!}</li>
                        </ul>
                    </li>
					<li>
                        <a href="{{ url('antrianpolis') }}"><i class="fa fa-flask"></i> <span class="nav-label">Nurse Station</span> </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Poli</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ url('ruangperiksa/umum') }}">Poli Umum</a> </li>
                            <li><a href="{{ url('ruangperiksa/anc') }}">Poli ANC</a> </li>
                            <li><a href="{{ url('ruangperiksa/suntikkb') }}">Suntik KB</a> </li>
                            <li><a href="{{ url('ruangperiksa/estetika') }}">Estetika</a> </li>
                            <li><a href="{{ url('ruangperiksa/usg') }}">Poli USG Kebidanan</a> </li>
                            <li><a href="{{ url('ruangperiksa/usgabdomen') }}">Poli USG Abdomen</a> </li>
                            <li><a href="{{ url('ruangperiksa/gigi') }}">Poli Gigi </a> </li>
                            <li><a href="{{ url('ruangperiksa/darurat') }}">Poli Gawat Darurat </a> </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('antriankasirs') }}"><i class="fa fa-flask"></i> <span class="nav-label">Antrian Apotek</span></a>
                    </li>
                     <li>
                        <a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Obat</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('mereks', 'Merek')!!}</li>
                            <li>{!! HTML::link('pdfs/merek', 'Merek PDF')!!}</li>
                            <li>{!! HTML::link('stokopnames', 'Stok Opname')!!}</li>
                            <li>{!! HTML::link('penjualans', 'Tanpa Resep')!!}</li>
                            <li>{!! HTML::link('obat/stokmin', 'Stok Minimal')!!}</li>
                            <li>{!! HTML::link('obat/pesanobat', 'Pesan Obat')!!}</li>
                            <li>{!! HTML::link('generiks', 'Data Generik Obat')!!}</li>
                            <li>{!! HTML::link('sediaans', 'Data Sediaan Obat')!!}</li>
                        </ul>
                    </li>
					@if(\Auth::id() == 28)
                     <li>
                        <a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Akuntansi</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('jurnal_umums', 'Jurnal Umum')!!}</li>
                            <li>{!! HTML::link('buku_besars', 'Buku Besar')!!}</li>
                            <li>{!! HTML::link('neraca_saldos', 'Neraca Saldo')!!}</li>
                            <li>{!! HTML::link('laporan_laba_rugis', 'Laporan Laba Rugi')!!}</li>
                            <li>{!! HTML::link('laporan_arus_kass', 'Laporan Arus Kas')!!}</li>
                            <li>{!! HTML::link('laporan_neracas', 'Laporan Neraca')!!}</li>
                            <li>{!! HTML::link('coas', 'Daftar Chart Of Acount')!!}</li>
                        </ul>
                     </li>
					@endif
                     <li>
                        <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Transaksi Kasir</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('no_sales', 'No Sales')!!}</li>
                            <li>{!! HTML::link('belanjalist', 'Belanja')!!}</li>
                            <li>{!! HTML::link('penjualans', 'Penjualan Obat Tanpa Resep')!!}</li>
                            <li>{!! HTML::link('penjualans/obat_buat_karyawan', 'Obat Untuk Karyawan')!!}</li>
                            <li>{!! HTML::link('pendapatans/create', 'Pendapatan Lain')!!}</li>
                            <li>{!! HTML::link('pendapatans/pembayaran/asuransi', 'Pembayaran Asuransi')!!}</li>
                            <li>{!! HTML::link('pengeluarans/bayardoker', 'Bayar Dokter')!!}</li>
                            <li>{!! HTML::link('pengeluarans/nota_z', 'Nota Z')!!}</li>
                            <li>{!! HTML::link('pengeluarans/rc', 'RC')!!}</li>
                            <li>{!! HTML::link('kasirs/saldo', 'Hitung Uang di Kasir')!!}</li>

                        </ul>
                    </li>
					@if(\Auth::id() == 28)
						<li>
							<a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Gaji dan Bagi Hasil</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>{!! HTML::link('pengeluarans/bayar_gaji_karyawan', 'Bayar Gaji Karyawan')!!}</li>
								<li>{!! HTML::link('pendapatans/pembayaran_bpjs', 'Pembayaran Kapitasi BPJS')!!}</li>
								<li>{!! HTML::link('pengeluarans/bagi_hasil_gigi', 'Bagi Hasil Gigi')!!}</li>
								<li>{!! HTML::link('pengeluarans/gaji_dokter_gigi', 'Gaji Dokter Gigi')!!}</li>
							</ul>
						 </li>
					@endif
					<li>
                        <a href="{{ url('mereks')}}"><i class="fa fa-flask"></i> <span class="nav-label">Fasilitas</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('fasilitas/antrian_pasien', 'Antrian Pasien')!!}</li>
                            <li>{!! HTML::link('fasilitas/survey', 'Survey Pasien')!!}</li>
                            <li>{!! HTML::link('facebook', 'Daftar dengan Facebook')!!}</li>
                            <li>{!! HTML::link('antrians', 'Input Antrian')!!}</li>
                            <li>{!! HTML::link('sms', 'SMS')!!}</li>

                            {{--<li>{!! HTML::link('sms/angkakontak', 'SMS Angka Kontak')!!}</li>--}}
                        </ul>
                     </li>
					@if(\Auth::id() == 28)
					<li>
                        <a href="{{ url('configs') }}"><i class="fa fa-flask"></i> <span class="nav-label">Pengaturan</span> </a>
                    </li>
					@endif
					<li>
                        <a href="{{ url('gammu')}}"><i class="fa fa-flask"></i> <span class="nav-label">Gammu</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>{!! HTML::link('gammu/inbox', 'Inbox')!!}</li>
                            <li>{!! HTML::link('gammu/pesanMasuk', 'Pesan Masuk')!!}</li>
                            <li>{!! HTML::link('gammu/outbox', 'Onbox')!!}</li>
                            <li>{!! HTML::link('gammu/pesanKeluar', 'Pesan Keluar')!!}</li>
                            <li>{!! HTML::link('gammu/sentitem', 'SentItem')!!}</li>
                            <li>{!! HTML::link('gammu/create/sms', 'Kirim SMS dengan Gammu')!!}</li>

                            {{--<li>{!! HTML::link('sms/angkakontak', 'SMS Angka Kontak')!!}</li>--}}
                        </ul>
                     </li>
					 <li>{!! HTML::link('backup', 'Backup Database', ['onclick' => 'return confirm("Anda yakin mau backup database saat ini?")'])!!}</li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
			<div class="panelLeft">
				<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			</div>
        </div>
		<ul class="nav navbar-top-links navbar-right">
		</ul>
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
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                @if (Session::has('pesan'))
                                    {!! Session::get('pesan')!!}
                                @endif
                            </div>
                        </div>
							@if( gethostname() == 'dell' )
							<div class="row fixed" id="antrianPasien" >
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="table-responsive">
										<table class="table table-hover table-condensed">
											<tbody>
												<tr>
													<td class="red-bg">
														<h3>Sudah Diperiksa No :</h3>
														<h2 id="antrianMaster">{{ App\Antrian::find(1)->antrian_terakhir }}</h2>
													</td>
													<td class="blue-bg">
														<h3>Antrian Terakhir No : </h3>
														<h2 id="antrianMaster">{{ App\Classes\Yoga::antrianTerakhir( date('Y-m-d') ) }}</h2>
												</tr>
											</tbody>
													</td>
										</table>
									</div>
								</div>
							</div>
							{{--<div class="row fixed full">--}}
								{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
									{{--<div class="row">--}}
										{{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-info">--}}
										{{--</div>--}}
										{{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-danger">--}}
											{{--<h3>Antrian Terakhir No : </h3>--}}
											{{--<h2 id="antrianMaster">{{ App\Classes\Yoga::antrianTerakhir( date('Y-m-d') ) }}</h2>--}}
										{{--</div>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--</div>--}}
							@endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        </div>
            {{--{!! HTML::script("js/all.js")!!}--}}
    <script src="{!! asset('js/all.js') !!}"></script>
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
		@if( gethostname() == 'dell' )
			{{--setInterval(function(){--}}
				{{--$.get('{{ url("master/ajax/antrianTerakhir") }}', { 'tanggal' : '{{ date('Y-m-d') }}' }, function(data) {--}}
					{{--var before = $('#antrianMaster').html();--}}
					{{--data = $.trim(data)--}}
						{{--if( before != data ){--}}
							{{--if( parseInt(data) > 0 ){--}}
								{{--$('#antrianPasien').hide().fadeIn(300);--}}
								{{--$('#antrianMaster').html(data);--}}
							{{--} else {--}}
								{{--$('#antrianPasien').fadeOut(300);--}}
								{{--$('#antrianMaster').html(data);--}}
							{{--}--}}
						{{--}--}}
				{{--});--}}
			{{--}, 5000);--}}
		@endif

        $(document).ready(function() {

            $('.uangInput').autoNumeric('init', {
                aSep: '.',
                aDec: ',', 
                aSign: 'Rp. ',
                vMin: '-9999999999999.99' ,
                mDec: 0
            });

            formatUang();
            
            $('.jumlah').each(function() {
                var number = $(this).html();
                number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
                $(this).html(number);
            });

            $('.selectpick')
                .selectpicker({
                style: 'btn-default',
                size: 10,
                selectOnTab : true,
                style : 'btn-white'
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

            $('.DTa').dataTable({
                "dom": 'T<"clear">lfrtip',
            });

            $('.DT').dataTable({
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
