@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Rayon

@stop
@section('page-title') 
<h2>Buat Rayon</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Rayon</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Buat Rayon</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'rayons', 'method' => 'post']) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('rayon'))has-error @endif">
								  {!! Form::label('rayon', 'Rayon', ['class' => 'control-label']) !!}
								  {!! Form::text('rayon' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('rayon'))<code>{{ $errors->first('rayon') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 colm-66 col-m66 col-lg-6">
								<div class="form-group">
								  {!! Form::submit('submit', ['class' => 'btn btn-success btn-block btn-lg']) !!}
								</div> 
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a class="btn btn-danger btn-block btn-lg" href="{{ url('rumahsakits') }}">Cancel</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">Rayon Yang Sudah Ada</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Rayon</th>
								</tr>
							</thead>
							<tbody>
								@if($rayons->count() > 0)
									@foreach($rayons as $r)
										<tr>
											<td>{{ $r->id }}</td>
											<td>{{ $r->rayon }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="2">Tidak Ada Data Untuk Ditampilkan :p</td>
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

