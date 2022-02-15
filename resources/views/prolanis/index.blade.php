@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Data Pasien Prolanis BPJS
@stop
@section('page-title') 
<h2>Data Pasien Prolanis BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Data Pasien Prolanis BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Data Pasien Prolanis BPJS</div>
	</div>
	<div class="panel-body">

		<div>
		
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#hipertensi" aria-controls="hipertensi" role="tab" data-toggle="tab">Hipertensi</a></li>
			<li role="presentation"><a href="#diabetes" aria-controls="diabetes" role="tab" data-toggle="tab">DM</a></li>
		  </ul>
		
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="hipertensi">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed DTa">
						<thead>
							<tr>
								<th>Nama Pasien</th>
								<th>No HP</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							@if(count($hipertensi) > 0)
								@foreach($hipertensi as $pro)
									<tr>
										<td>{{ $pro->nama }} <br> ( {{ $pro->id }} ) </td>
										<td>{{ $pro->no_telp }}</td>
										<td> <a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $pro->id) }}">detail</a> </td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			
			</div>
			<div role="tabpanel" class="tab-pane" id="diabetes">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-condensed DTa">
						<thead>
							<tr>
								<th>Nama Pasien</th>
								<th>No HP</th>
								<th>Riwayat GDS</th>
								<th>Action</th>

							</tr>
						</thead>
						<tbody>
							@if(count($dm) > 0)
								@foreach($dm as $pro)
									<tr>
										<td>{{ $pro->nama }} <br> ( {{ $pro->id }} ) </td>
										<td>{{ $pro->no_telp }}</td>
										<td>{!! $pro->riwgds !!}</td>
										<td> <a class="btn btn-info btn-xs btn-block" href="{{ url('pasiens/' . $pro->id) }}">detail</a> </td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		  </div>
		</div>
		
	</div>
</div>

@stop
@section('footer') 
	
@stop

