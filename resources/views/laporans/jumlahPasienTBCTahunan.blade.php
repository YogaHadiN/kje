@extends('layout.master')

@section('title') 
Klinik Jati Elok | Jumlah Pasien TBC Tahunan

@stop
@section('page-title') 
<h2>Jumlah Pasien TBC Tahunan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Jumlah Pasien TBC Tahunan</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Jumlah Pasien TBC Tahun {{ $tahun }}</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Jenis Kelamin</th>
									<th>Tanggal Lahir</th>
									<th>Pekerjaan</th>
									<th>Alamat / Nomor Kontak</th>
									<th>Diagnosa</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody>
								@if(count($data) > 0)
									@foreach($data as $d)
										<tr>
											<td>{{ $d->nama }}</td>
											<td>{{ $d->sex }}</td>
											<td>{{ $d->tanggal_lahir }}</td>
											<td></td>
											<td>{{ $d->alamat }}</td>
											<td>{{ $d->icd }} - {{ $d->diagnosa }}</td>
											<td></td>
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
					
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
@stop

