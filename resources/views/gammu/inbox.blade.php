@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Inbox Gammu

@stop
@section('page-title') 
<h2>Inbox Gammu</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Inbox Gammu</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					Pesan dari {{ $mulai }} sampai {{ $akhir }}
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Message</th>
							<th>Pengirim</th>
						</tr>
					</thead>
					<tbody>
						@if(count($message) > 0)
							@foreach($message as $m)
								<tr>
									<td>{{ $m['date'] }}</td>
									<td>{{ $m['isiPesan'] }}</td>
									<td>{{ $m['dari'] }}</td>
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

