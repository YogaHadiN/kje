@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Harian

@stop
@section('head')
    <link href="{!! asset('css/print.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 

 <h2>Laporan Harian</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Harian</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <h2 class="panel-title">Ringkasan Laporan</h2>
              </div>
              <div class="panel-body">
				  <div class="table-responsive">
					  <table class="table table-condensed table-hover">
						  <thead>
							  <tr>
								  <th>Nama Asuransi</th>
								  <th>Jumlah</th>
								  @foreach($polis as $poli)	
									  <th>{{ $poli }}</th>
								  @endforeach
							  </tr>
						  </thead>
						  <tbody>
							  @if (count($hariinis) > 0)
								  @foreach ($hariinis as $hariini)
									  <tr>
										  <td>{!! $hariini->nama !!}</td>
										  <th>{!! $hariini->jumlah !!}</th>
										  @foreach($polis as $poli)	
											  <td class="text-center">{{ App\Classes\Yoga::periksa_by_asuransi($tanggal, $hariini->id, $poli) }}</td>
										  @endforeach
									  </tr>
								  @endforeach
							  @else
								  <tr>
									  <td colspan="2" class="text-center">Tidak ada data untuk ditampilkan :p</td>
								  </tr>
							  @endif
						  </tbody>
						  <tfoot>
							  <th> Jumlah </th>
							  <th>{!! count($periksas) !!}</th>
							  @foreach($polis as $poli)	
								  <th class="text-center">{{ App\Classes\Yoga::periksa_by_poli($tanggal, $poli) }}</th>
							  @endforeach
						  </tfoot>
					  </table>
				  </div>
              </div>
        </div>
    </div>
</div>
@if( 
	\App\User::find(\Auth::id())->role == '2' ||
	\App\User::find(\Auth::id())->role == '3' ||
	\App\User::find(\Auth::id())->role == '4' ||
	\App\User::find(\Auth::id())->role == '6' 
	)

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
			  <div class="panel-heading">
					<div class="panel-title">
						<div class="panelLeft">
							<h3>Laporan Tanggal : {!! App\Classes\Yoga::updateDatePrep($tanggal) !!}</h3>
						</div>
						<div class="panelRight">
							<h3>Total : {!! count($periksas) !!}</h3>
						</div>
					</div>
			  </div>
			  <div class="panel-body">
				  <div class="table-responsive">
					  <table class="table table-bordered table-hover" id="tableAsuransi">
						  <thead>
							  <tr>
								  <th class="hide">ID PERIKSA</th>
								  <th>Periksa Id</th>
								  <th>Nama Pasien</th>
								  <th>Pembayaran</th>
								  <th>Poli</th>
								  <th>Tunai</th>
								  <th>Piutang</th>
								  <th>Action</th>
							  </tr>
						  </thead>
						  <tbody>
							  @if (count($periksas) > 0)
								  @foreach ($periksas as $key => $periksa)
									  <tr>
										  <td class="hide periksa_id">{!! $periksa->periksa_id !!}</td>
										  <td>{!! $periksa->periksa_id !!}</td>
										  <td>{!! $periksa->nama_pasien !!}</td>
										  <td>{!! $periksa->nama_asuransi !!}</td>
										  <td>{!! $periksa->poli !!}</td>
										  <td class='uang'>{!! $periksa->tunai !!}</td>
										  <td class='uang'>{!! $periksa->piutang !!}</td>
										  <td>
											  <a href="{{ url('pdfs/kuitansi/' . $periksa->periksa_id ) }}" target="_blank">Kuitansi</a> | 
											  <a href="{{ url('pdfs/status/' . $periksa->periksa_id ) }}" target="_blank">Resep</a> | 
											  <a href="{{ url('periksas/' . $periksa->periksa_id ) }}" target="_blank">Detail</a> | 
											  <a href="{{ url('pdfs/struk/' . $periksa->periksa_id ) }}" target="_blank">Struk</a>  @if($periksa->asuransi_id == '32') |
											  <a href="{{ url('laporans/periksa/pengantar/' . $periksa->periksa_id . '/edit') }}" target="_blank">Pengantar</a> @endif  
										  </td>
									  </tr>
								  @endforeach
							  @else
								  <tr>
									  <td colspan="6" class="text-center">Tidak / Belum ada transaksi tanggal {!! App\Classes\Yoga::updateDatePrep($tanggal) !!}</td>
								  </tr>
							  @endif
						  </tbody>
						  <tfoot>
							  <tr>
								  <th colspan="4">Total</th>
								  <td class="uang">{!! App\Classes\Yoga::totalTunaiHarian($periksas)!!}</td>
								  <td class="uang">{!! App\Classes\Yoga::totalPiutangHarian($periksas)!!}</td>
							  </tr>
						  </tfoot>
					  </table>
				  </div>
			  </div>
		</div>
	</div>
	</div>
	@endif
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
    function printStruk(control){
        alert( $(control).closest('tr').find('.periksa_id').html() );
    }
    
</script>
@stop
