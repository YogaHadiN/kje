@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Bulanan

@stop
@section('page-title') 

 <h2>Laporan Bulanan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Bulanan</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Laporan Angka Kontak BPJS</div>
			</div>
			<div class="panel-body">
				<h1>Angka Kontak</h1>
				<h3>{{ $angka_kontak }}</h3>
				<h1>Angka Kunjungan</h1>
				<h3>{{ $angka_kunjungan }}</h3>
			</div>
		</div>
		
	</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">
                    </div>
                    <div class="panelRight">
                        <h3>Total : {!! count($bulan) !!}</h3>
                    </div>
                </div>
          </div>
          <div class="panel-body">
			  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
						  <thead>
							<tr>
								<th>No</th>
								<th>Nama Asuransi</th>
								<th>Tunai</th>
								<th>Piutang</th>
								<th>Modal Obat</th>
								<th>Modal/Pasien</th>
								<th>Bruto</th>
								<th>Keuntungan</th>
								<th>Jumlah</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if (count($bulan) > 0)
								@foreach ($bulan as $key => $bln)
								<tr>
									<td>{!! $key + 1 !!}</td>
									<td>{!! $bln->nama !!}</td>
									<td class="uang">{!! $bln->tunai !!}</td>
									<td class="uang">{!! $bln->piutang !!}</td>
									<td class="uang">{!! App\Models\Classes\Yoga::modalBulanIni($tanggal, $bln->id) !!}</td>
									<td class="uang">
									@if($bln->jumlah > 0)
										{!! (int)(App\Models\Classes\Yoga::modalBulanIni($tanggal, $bln->id) / $bln->jumlah) !!}
									@endif
									</td>
									<td class="uang">{!! $bln->piutang + $bln->tunai !!}</td>
									<td class="uang">{!! $bln->piutang + $bln->tunai - App\Models\Classes\Yoga::modalBulanIni($tanggal, $bln->id) !!}</td>
									<td>{!! $bln->jumlah !!}</td>
									<td><a href="{{ url('laporans/detbulan?submit=submit&bulanTahun='. $tanggall . '&asuransi_id=' .$bln->id) }}" class="btn btn-success btn-xs">detail</a></td>

								</tr>
								@endforeach
							@else
								<tr>
									<td colspan="6" class="text-center">Tidak / Belum ada transaksi tanggal</td>
								</tr>
							@endif
						</tbody>
						<tfoot>
						  <tr>

							<th colspan="2"> Total </th>
							<td class="uang">{!! App\Models\Classes\Yoga::tunaiBulanan($bulan)!!}</td>
							<td class="uang">{!! App\Models\Classes\Yoga::piutangBulanan($bulan)!!}</td>
							<td class="uang">{!! App\Models\Classes\Yoga::modalBulanIni($tanggal, '%')!!}</td>
							<td class="uang">
								@if($periksa->count() > 0)
									{!! (int)(App\Models\Classes\Yoga::modalBulanIni($tanggal, '%') / $periksa->count()) !!}
								@endif
							</td>
							<td class="uang">{!! App\Models\Classes\Yoga::tunaiBulanan($bulan) + App\Models\Classes\Yoga::piutangBulanan($bulan) !!}</td>
							<td class="uang">{!! App\Models\Classes\Yoga::tunaiBulanan($bulan) + App\Models\Classes\Yoga::piutangBulanan($bulan) -App\Models\Classes\Yoga::modalBulanIni($tanggal, '%') !!}</td>
							<td>{!! $periksa->count() !!}</td>

						  </tr>
						</tfoot>
					</table>
			  </div>
          </div>
    </div>
    </div>

</div>

@stop
@section('footer') 
	
@stop
