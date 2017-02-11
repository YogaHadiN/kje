@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftar Peralatan

@stop
@section('page-title') 
<h2>Daftar Peralatan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Peralatan</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Golongan Peralatan</div>
					</div>
					<div class="panelRight">
						<a class="btn btn-primary" href="{{ url('pengeluarans/peralatans/golongan_peralatans/create') }}"> Golongan Peralatan Baru</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed">
							<thead>
								<tr>
									<th>Golongan Peralatan</th>
									<th>Masa Pakai</th>
								</tr>
							</thead>
							<tbody>
								@foreach( $golongan_peralatans as $gol )
									<tr>
										<td>{{ $gol->golongan_peralatan }}</td>
										<td>{{ $gol->masa_pakai }} tahun</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				  <div class="panel-heading">
					  <div class="panelLeft">
							<div class="panel-title">Belanja Peralatan Yang Sudah Dilakukan</div>
					  </div>
					  <div class="panelRight">
						  <a class="btn btn-success" href="{{ url('pengeluarans/belanja/peralatan') }}">Belanja Peralatan Baru</a>
					  </div>
				  </div>
				  <div class="panel-body">
					<?php echo $belanja_peralatans->appends(Input::except('page'))->links(); ?>
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Created At</th>
										<th>Petugas</th>
										<th>Peralatan</th>
										<th>Masa Pakai</th>
										<th>Harga Satuan</th>
										<th>Jumlah</th>
										<th>Penyusutan</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if($belanja_peralatans->count() > 0)
										@foreach($belanja_peralatans as $fb)
											<tr>
												<td>{{ $fb->fakturBelanja->tanggal->format('d-m-Y') }}</td>
												<td>{{ $fb->fakturBelanja->created_at->format('d-m-Y') }}</td>
												<td>{{ $fb->staf->nama }}</td>
												<td>{{ $fb->peralatan }}</td>
												<td>{{ $fb->masa_pakai }} tahun</td>
												<td class="uang">{{ $fb->harga_satuan }}</td>
												<td>{{ $fb->jumlah }}</td>
												<td class="uang">{{ $fb->penyusutan }}</td>
												<td><a class="btn btn-info btn-xs" href="{{ url('pengeluarans/peralatans/detail/'. $fb->id) }}">detail</a> </td>
											</tr>
										@endforeach
									@else
										<tr>
											<td class="text-center" colspan="8">Tidak Ada Data Untuk Ditampilkan :p</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					<?php echo $belanja_peralatans->appends(Input::except('page'))->links(); ?>
				  </div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	@if( Session::has('print') )
		<script type="text/javascript" charset="utf-8">
			var base = "{{ url('/') }}";
			window.open(base + "/pdfs/pembelian/{!! Session::get('print') !!}");
		</script>	
	@endif
@stop
