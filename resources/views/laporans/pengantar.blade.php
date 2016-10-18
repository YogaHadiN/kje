@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pengantar Pasien BPJS

@stop

@section('head') 
<style type="text/css" media="all">
table tr th:first-child, table tr td:first-child {
	width:10%;
}

table tr th:nth-child(2), table tr td:nth-child(2) {
	width:10%;
}

table tr th:nth-child(3), table tr td:nth-child(3) {
	width:40%;
}

table tr th:nth-child(4), table tr td:nth-child(4) {
	width:40%;
}
</style>

@stop
@section('page-title') 
<h2>Laporan Pengantar Pasien BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Pengantar Pasien BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Laporan Pengantar Pasien BPJS</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>pasien id</th>
							<th>Nama Pengantar</th>
							<th>KTP</th>
							<th>BPJS</th>
						</tr>
					</thead>
					<tbody>
						@if(count($pp) > 0)
							@foreach($pp as $p)
								<tr>
									<td>{{ $p->periksa_id }}</td>
									<td>{{ $p->nama_pengantar }}</td>
									<td>{{ $p->ktp }}</td>
									<td> <img src="{{ url('/'). '/' . $p->bpjs }}" alt="" class="img-rounded upload" /> </td>
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
	
@stop
@section('footer') 
	
@stop

