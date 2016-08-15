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
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Petugas</th>
										<th>Peralatan</th>
										<th>Masa Pakai</th>
										<th>Harga Awal</th>
										<th>Penyusutan</th>
									</tr>
								</thead>
								<tbody>
									@if($belanja_peralatans->count() > 0)
										@foreach($belanja_peralatans as $fb)
											<tr>
											<td>{{ $fb->fakturBelanja->tanggal->format('d-m-Y') }}</td>
												<td>{{ $fb->staf->nama }}</td>
												<td>{{ $fb->peralatan }}</td>
												<td>{{ $fb->masa_pakai }} tahun</td>
												<td class="uang">{{ $fb->nilai }}</td>
												<td class="uang">{{ $fb->penyusutan }}</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
				  </div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
@stop
