@extends('layout.master')

@section('title') 
Klinik Jati Elok | Alergi Obat

@stop
@section('page-title') 
<h2>Alergi Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Alergi Obat</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Alergi Obat {{ $pasien->nama }}</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Alergi</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($alergies->count() > 0)
							@foreach($alergies as $alergi)
								<tr>
									<td>{{ $alergi->generik->generik }}</td>
									<td nowrap class="autofit">
										{!! Form::open(['url' => 'alergies/' . $alergi->id, 'method' => 'delete']) !!}
											<a class="btn btn-warning btn-sm" href="{{ url('alergies/' . $alergi->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
											<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $alergi->id }} - {{ $alergi->generik->generik }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="2" class="text-center">Tidak ada data ditemukan</td>
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

