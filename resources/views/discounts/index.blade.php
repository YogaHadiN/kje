
@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Diskon

@stop
@section('page-title') 
<h2>Diskon</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Diskon</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					Daftar Diskon
				</div>
				<div class="panelRight">
					<a class="btn btn-primary" href="{{ url("discounts/create") }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Buat Diskon Baru</a>

				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed DT">
					<thead>
						<tr>
							<th>ID</th>
							<th>Jenis Tarif</th>
							<th>Untuk Pembayaran</th>
							<th>Berlaku</th>
							<th>Diskon</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($discounts->count() > 0)
							@foreach($discounts as $d)
								<tr>
									<td>{{ $d->jenis_tarif_id }}</td>
									<td nowrap>{{ $d->jenisTarif->jenis_tarif }}</td>
									<td>
										@if( $d->discountAsuransi->count() == $jumlahAsuransi )
											Semua Asuransi
										@else
											{{ $d->discountAsuransi->count() }} asuransi
											<ul>
											@foreach($d->discountAsuransi as $di)	
												<li>{{ $di->asuransi->nama }}</li>	
											@endforeach
											</ul>
										@endif
									</td>
									<td>
										Berlaku <br />
										<strong>{{ $d->dimulai->format('d M Y') }}</strong> <br />
										s/d <br />
										<strong>{{ $d->berakhir->format('d M Y') }}</strong> <br />

									</td>
									<td class="text-right">{{ $d->diskon_persen }} %</td>
									<td> 
												<a class="btn btn-xs btn-warning btn-block" href="{{ url("discounts/" . $d->id . '/edit') }}">Edit</a> 
												<a class="btn btn-xs btn-danger btn-block" href="{{ url("discounts/" . $d->id . '/delete') }}" onclick="return confirm('Anda Yakin mau menghapus Diskon {{ $d->jenisTarif->jenis_tarif }} sebesar {{ $d->diskon_persen }} %?')">Delete</a> </td>
										</div>
										
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="7">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
@stop
@section('footer') 
	
@stop
		
