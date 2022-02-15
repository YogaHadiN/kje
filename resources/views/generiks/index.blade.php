@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Data Obat Generik

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
				<table class="table table-hover table-condensed DT table-bordered">
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
									<td>
										@if($generik->id > 1152)
										{!! Form::open(['url' => 'generiks/' . $generik->id, 'method' => 'delete']) !!}
											<div class="form-group">
											  {!! Form::submit('Hapus', [
												  'class' => 'btn btn-danger btn-block btn-xs',
												  'onclick' => 'return confirm("Apa anda yakin mau menghapus ' . $generik->generik . ' ?")'
											  ]) !!}
											</div> 
										{!! Form::close() !!}
										
										@else
										<button class="btn btn-danger btn-block btn-xs" type="button" disabled>Hapus</button>
										@endif
									
									</td>
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

