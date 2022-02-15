@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Daftar Sediaan Obat

@stop
@section('page-title') 
<h2>Daftar Sediaan Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Sediaan Obat</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">
				
					<div class="panelLeft">
						Daftar Sediaan Obat
					</div>
					<div class="panelRight">
						<a class="btn btn-info" href="{{ url('sediaans/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Sediaan Baru</a>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Id</th>
								<th>Sediaan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($sediaans->count() > 0)
								@foreach($sediaans as $sediaan)
									<tr>
										<td>{{ $sediaan->id }}</td>
										<td>{{ $sediaan->sediaan }}</td>
										<td>
											{!! Form::open(['url' => 'sediaans/' . $sediaan->id, 'method' => 'delete']) !!}
												<div class="form-group">
												  {!! Form::submit('Hapus', [
													  'class' => 'btn btn-danger btn-block btn-xs',
													  'onclick' => 'return confirm("Apa anda yakin mau menghapus ' . $sediaan->sediaan . ' ?")'
												  ]) !!}
												</div> 
											{!! Form::close() !!}
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
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

