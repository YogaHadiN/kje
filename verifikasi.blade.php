@extends('layout.master')

@section('title') 
Klinik Jati Elok | Verifikasi Data Prolanis

@stop
@section('page-title') 
<h2>Verifikasi Data Prolanis</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Verifikasi Data Prolanis</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Nama XL</th>
						<th>Usia XL</th>
						<th>Jenis Kelamin XL</th>
						<th>Alamat XL</th>
						<th>Nama</th>
						<th>Usia</th>
						<th>Jenis Kelamin</th>
						<th>Alamat</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if($prolanis->count() > 0)
						@foreach($prolanis as $p)
							<tr>
								<td>{{ $p->nama }}</td>
								<td>{{ $p->usia }}</td>
								<td>{{ $p->jenis_kelamin }}</td>
								<td>{{ $p->alamat }}</td>
								<td>{{ $p->pasien->nama }}</td>
								<td>{{ $p->pasien->usia }}</td>
								<td>{{ $p->pasien->jenis_kelamin }}</td>
								<td>{{ $p->pasien->alamat }}</td>
								<td nowrap class="autofit">
									{!! Form::open(['url' => 'model/' . $->id, 'method' => 'delete']) !!}
										<a class="btn btn-warning btn-sm" href="{{ url('model/' . $->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
										<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ ->id }} - {{ -> }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
									{!! Form::close() !!}
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
