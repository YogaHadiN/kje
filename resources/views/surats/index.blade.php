@extends('layout.master')

@section('title') 
Online Electronic Medical Record | Nurse Station

@stop
@section('page-title') 
<h2>Nurse Station</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('home')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Nurse Station</strong>
	  </li>
</ol>

@stop
@section('content') 

            <a href="{{ url( 'surats/create' ) }}" type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</a>
			<br />
			<br />
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Nomor Surat</th>
							<th>Jenis Surat</th>
							<th>Alamat Tujuan / Dari</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($surats->count() > 0)
							@foreach($surats as $surat)
								<tr>
									<td>{{ $surat->tanggal->format('d M Y') }}</td>
									<td>{{ $surat->nomor_surat }}</td>
									<td>
										@if( $surat->surat_masuk)
											Surat Masuk
										@else
											Surat Keluar
										@endif
									</td>
									<td>{{ $surat->alamat }}</td>
									<td nowrap class="autofit">
										{!! Form::open(['url' => 'surats/' . $surat->id, 'method' => 'delete']) !!}
											<a class="btn btn-warning btn-sm" href="{{ url('surats/' . $surat->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
											<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus surat?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="6" class="text-center">Tidak ada data ditemukan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
@stop
@section('footer') 
	
@stop

