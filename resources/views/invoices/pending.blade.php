@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Pending Received Verification

@stop
@section('page-title') 
<h2>Pending Received Verification</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pending Received Verification</strong>
	  </li>
</ol>

@stop
@section('content') 
	<h1>Terdapat {{ count( $pending )}} Yang Belum Diterima Admedika</h1>
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Invoice</th>
					<th>Tanggal Pengiriman</th>
					<th>Asuransi</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if(count($pending) > 0)
					@foreach($pending as $p)
						<tr>
							<td>{{ $p->invoice_id }}</td>
							<td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
							<td>{{ $p->nama_asuransi }}</td>
							<td nowrap class="autofit">
								<a class="btn btn-info btn-sm" href="{{ url('invoices/' . $p->invoice_id )}}" target="_blank"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Verifikasi</a>
							</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="">
							{!! Form::open(['url' => 'model/imports', 'method' => 'post', 'files' => 'true']) !!}
								<div class="form-group">
									{!! Form::label('file', 'Data tidak ditemukan, upload data?') !!}
									{!! Form::file('file') !!}
									{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
								</div>
							{!! Form::close() !!}
						</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
		
@stop
@section('footer') 
	
@stop
