@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Input Pengantar Pasien

@stop
@section('page-title') 
<h2>Input Pengantar Pasien</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Input Pengantar Pasien</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Input Pengantar Pasien</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Pengantar</th>
							<th>Gambar Kartu BPJS</th>
						</tr>
					</thead>
					<tbody>
					
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<div class="input-group">
									{!! Form::select('pengantar_pasien' , [], null, ['class' => 'productName form-control']) !!}
									<span class="input-group-addon anchor" id="showModal1" data-toggle="modal" data-target="#exampleModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
								</div>
							</td>
							<td>
								<button class="btn btn-primary btn-block" type="button" onclick="entry();return false;">Input</button>
							
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	{!! Form::open(['url' => 'antrianpolis/pengantar/create', 'method' => 'post']) !!}
		{!! Form::text('antrian_poli_id', $id, ['class' => 'form-control hide']) !!}
		{!! Form::textarea('jsonArray', null, ['class' => 'form-control hide']) !!}
	{!! Form::close() !!}
	
@stop
@section('footer') 
	
@stop

