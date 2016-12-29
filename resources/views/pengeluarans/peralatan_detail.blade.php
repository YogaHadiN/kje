@extends('layout.master')

@section('title') 
Klinik Jati Elok | Detail Pembelian Peralatan

@stop
@section('page-title') 
<h2>Detail Pembelian Peralatan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Detail Pembelian Peralatan</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Detail Pembelian Peralatan</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Keterangan</th>
								<th>Petugas</th>
								<th>Harga Satuan</th>
								<th>Jumlah</th>
								<th>Masa Pakai</th>
								<th>Penyusutan</th>
							</tr>
						</thead>
						<tbody>
							@if($fakturbelanja->belanjaPeralatan->count() > 0)
								@foreach($fakturbelanja->belanjaPeralatan as $f)
									<tr>
										<td>{{ $f->peralatan }}</td>
										<td>{{ $f->staf->nama }}</td>
										<td class="uang">{{ $f->harga_satuan }}</td>
										<td>{{ $f->jumlah }}</td>
										<td>{{ $f->masa_pakai }} tahun</td>
										<td>{{ $f->penyusutan }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Nota</div>
			</div>
			<div class="panel-body">
				<img src="{{ url('img/belanja/alat/'.$fakturbelanja->faktur_image) }}" class="img-rounded" alt="Responsive image">
			</div>
		</div>
	</div>
</div>
@stop
@section('footer') 
	
@stop

