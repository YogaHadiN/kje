@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pesan Masuk

@stop
@section('page-title') 
<h2>Pesan Masuk</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pesan Masuk</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					Update pada {{ date('d-m-Y H:i:s') }}
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Message</th>
							<th>Pengirim</th>
							<th colspan="2">Action</th>
						</tr>
					</thead>
					<tbody>
						@if($inbox->count() > 0)
							@foreach($inbox as $i)
								<tr>
									<td>{{ $i->pesan }}</td>
									<td>{{ $i->periksa->pasien->no_telp }}</td>
									<td> <a class="btn btn-xs btn-info" href="{{ url("gammu/reply/" . $i->SenderNumber) }}">Reply</a> </td>
									<td> <a class="btn btn-xs btn-danger" href="{{ url("gammu/" . $i->SenderNumber . '/delete') }}">Delete</a> </td>
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

