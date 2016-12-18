
@extends('layout.master')
@section('title') 
Klinik Jati Elok | Diskon

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
					<a class="btn btn-primary" href="{{ url("discounts/create") }}">Buat Diskon Baru</a>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Tarif Id</th>
							<th>Jenis Tarif</th>
							<th>Diskon</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<tbody>
						@if($discounts->count() > 0)
							@foreach($discounts as $d)
								<tr>
									<td>{{ $d->tarif_id }}</td>
									<td>{{ $d->tarif->jenisTarif->jenis_tarif }}</td>
									<td>{{ $d->diskon_persen }}</td>
									<td> <a class="btn btn-xs btn-warning" href="{{ url("") }}">Edit</a> </td>
									<td> <a class="btn btn-xs btn-danger" href="{{ url("") }}">Delete</a> </td>
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
		
