@extends('layout.master')

@section('title') 
Klinik Jati Elok | Data Obat Generik

@stop
@section('page-title') 
<h2>Data Obat Generik</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Data Obat Generik</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					Data Obat Generik
				</div>
				<div class="panelRight">
					<a class="btn btn-primary" href="{{ url('generiks/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Buat Generik Baru</a>
				</div>
			
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed DT">
					<thead>
						<tr>
							<th>id</th>
							<th>Nama Generik</th>
							<th>Pregnancy Safety</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($generiks->count() > 0)
							@foreach($generiks as $generik)
								<tr>
									<td>{{ $generik->id }}</td>
									<td>{{ $generik->generik }}</td>
									<td>{{ $generik->pregnancy_safety_index }}</td>
									<td>Action</td>
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
	
@stop
@section('footer') 
	
@stop

