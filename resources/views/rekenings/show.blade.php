@extends('layout.master')

@section('title') 
	Klinik Jati Elok | Detail Pembayaran Rekening {{ $rekening->id }}

@stop
@section('page-title') 
	<h2>Detail Pembayaran {{ $rekening->id}}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Detail Pembayaran {{ $rekening->id }}</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#deskripsi" aria-controls="deskripsi" role="tab" data-toggle="tab">Deskripsi</a></li>
			<li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detail</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="deskripsi">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Deskripsi Rekening</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered">
								<tbody>
									<tr>
										<td>Nama Bank</td>
										<td>{{ $rekening->akun_bank->akun }}</td>
									</tr>
									<tr>
										<td>Nomor Rekening</td>
										<td>{{ $rekening->akun_bank->nomor_rekening }}</td>
									</tr>
									<tr>
										<td>Nilai</td>
										<td>{{ App\Models\Classes\Yoga::buatrp($rekening->nilai) }}</td>
									</tr>
									<tr>
										<td>Deskripsi</td>
										<td>{{ $rekening->deskripsi }}</td>
									</tr>
									<tr>
										<td>Tanggal</td>
										<td>{{ $rekening->tanggal->format('d F Y') }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Deskripsi Pembayaran</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed table-bordered">
									<tbody>
										<tr>
											<td>Nama Asuransi</td>
											<td>{{ $rekening->pembayaran_asuransi->asuransi->nama }}</td>
										</tr>
										<tr>
											<td>Periode</td>
											<td>{{ $rekening->pembayaran_asuransi->mulai->format('d F Y') }} - {{ $rekening->pembayaran_asuransi->akhir->format('d F Y') }} </td>
										</tr>
										<tr>
											<td>Tanggal Input</td>
											<td>{{ $rekening->pembayaran_asuransi->created_at->format('d F Y') }}</td>
										</tr>
										<tr>
											<td>Tanggal Dibayar</td>
											<td>{{ $rekening->pembayaran_asuransi->tanggal_dibayar->format('d F Y') }}</td>
										</tr>
										<tr>
											<td>Nama Staf</td>
											<td>{{ $rekening->pembayaran_asuransi->staf->nama }}</td>
										</tr>
										<tr>
											<td>Jumlah Pembayaran</td>
											<td>{{ App\Models\Classes\Yoga::buatrp($rekening->pembayaran_asuransi->pembayaran)  }}</td>
										</tr>
										<tr>
											<td>ID Pembayaran</td>
											<td>
												<a href="{{ url('pembayaran_asuransis/' .$rekening->pembayaran_asuransi->id ) }}" target="_blank">
													{{ $rekening->pembayaran_asuransi->id }}
												</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="detail">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>periksa_id</th>
								<th>Nama Pasien</th>
								<th>Tunai</th>
								<th>Piutang</th>
								<th>Sudah Dibayar</th>
								<th>Sisa Hutang</th>
							</tr>
						</thead>
						<tbody>
							@if($rekening->pembayaran_asuransi->piutang_dibayar->count() > 0)
								@foreach($rekening->pembayaran_asuransi->piutang_dibayar as $piutang)
									<tr>
										<td>
											<a href="{{ url('periksas/' . $piutang->periksa_id) }}" target="_blank">
												{{ $piutang->periksa->tanggal }}
											</a>
										</td>
										<td>
											<a href="{{ url('pasiens/' . $piutang->periksa->pasien_id . '/edit') }}" target="_blank">
												{{ $piutang->periksa->pasien->nama }}
											</a>
										</td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $piutang->periksa->tunai ) }}</td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $piutang->periksa->piutang ) }}</td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $piutang->pembayaran ) }}</td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $piutang->periksa->piutang - $piutang->pembayaran ) }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
								</tr>
							@endif
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total Pembayaran</th>
								<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_tunai ) }}</th>
								<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</th>
								<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</th>
								<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_piutang - $total_sudah_dibayar  ) }}</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		  </div>
		</div>
@stop
@section('footer') 
	
@stop
