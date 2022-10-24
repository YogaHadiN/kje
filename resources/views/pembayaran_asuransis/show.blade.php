@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Detail Pembayaran Asuransi

@stop
@section('page-title') 
<h2>Detail Pembayaran Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Detail Pembayaran Asuransi</strong>
	  </li>
</ol>

@stop
@section('content') 
<h1>Detail Pembayaran Asuransi</h1>
<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#pembayaran" aria-controls="pembayaran" role="tab" data-toggle="tab">Pembayaran</a></li>
	<li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detail Pembayaran</a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="pembayaran">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<tbody>
					<tr>
						<td>Asuransi</td>
						<td>{{ $pembayaran->asuransi->nama }}</td>
					</tr>
					<tr>
						<td>Periode</td>
						<td>{{ $pembayaran->mulai->format('d-m-Y')  }} - {{ $pembayaran->akhir->format('d-m-Y') }}</td>
					</tr>
					<tr>
						<td>Tanggal input</td>
						<td>{{ $pembayaran->created_at->format('d-m-Y') }}</td>
					</tr>
					<tr>
						<td> pembayaran </td>
						<td>{{ App\Models\Classes\Yoga::buatrp( $pembayaran->pembayaran ) }}</td>
					</tr>
					<tr>
						<td> tanggal dibayar </td>
						<td>{{ $pembayaran->tanggal_dibayar->format('d-m-Y') }}</td>
					</tr>
					<tr>
						<td>Kas ke</td>
						<td>{{ $pembayaran->coa->coa }}</td>
					</tr>
					<tr>
						<td>Staf Penginput</td>
						<td>{{ $pembayaran->staf->nama }}</td>
					</tr>
					@if ( $pembayaran->rekening )
						<tr>
							<td>Transaksi Id Transfer</td>
							<td>{{ $pembayaran->rekening->id }}</td>
						</tr>
						<tr>
							<td>Transaksi Deskripsi Transfer</td>
							<td>{{ $pembayaran->rekening->deskripsi }}</td>
						</tr>
						<tr>
							<td>Nilai Transfer</td>
							<td class="uang">{{ $pembayaran->rekening->nilai }}</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="detail">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Tanggal Pemeriksaan</th>
						<th>Nama</th>
						<th>Piutang</th>
						<th>Pembayaran</th>
						<th>Sisa</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($pembayaran_asuransi) > 0)
						@foreach($pembayaran_asuransi as $pa)
							<tr>
								<td>
									<a href="{{ url('periksas/' . $pa->periksa_id) }}" target="_blank">
										{{ date('d M y', strtotime( $pa->tanggal )) }}
									</a>
								</td>
								<td>	
									<a href="{{ url('pasiens/' . $pa->pasien_id . '/edit')  }}" target="_blank">
										{{ $pa->nama_pasien }}
									</a>
								</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pa->piutang )}}</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pa->pembayaran )}}</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp(  $pa->piutang - $pa->pembayaran )}}</td>
								<td>
									<a class="btn btn-warning btn-sm" href="{{ url('piutang_dibayars/' . $pa->piutang_dibayar_id . '/edit') }}">Edit</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td>
							<h3 class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_pembayaran )}}</h3>
						</td>
						<td>
							<h3 class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_piutang )}}</h3>
						</td>
						<td>
							<h3 class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_sisa_piutang )}}</h3>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
  </div>

</div>
	{!! Form::open(['url' => 'pembayaran_asuransis/' . $pembayaran->id , 'method' => 'delete']) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!! Form::submit('Delete', [
							'class' => 'btn btn-danger btn-block',
							'onclick' => 'return confirm("Anda akan menghapus pembayaran asuransi dengan id ' . $pembayaran->id . '")',
							'id'    => 'submit'
						]) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop
@section('footer') 
	
@stop

