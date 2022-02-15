@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Rumah Sakit Baru

@stop
@section('page-title') 
<h2>Buat Rumah Sakit Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Rumah Sakit Baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Rumah Sakit Baru</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'rumahsakits', 'method' => 'post']) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('nama'))has-error @endif">
								  {!! Form::label('nama', 'Nama Rumah Sakit', ['class' => 'control-label']) !!}
								  {!! Form::text('nama' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('alamat'))has-error @endif">
								  {!! Form::label('alamat', 'Alamat Rumah Sakit', ['class' => 'control-label']) !!}
								  {!! Form::textarea('alamat' , null, ['class' => 'form-control textareacustom']) !!}
								  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('jenis_rumah_sakit'))has-error @endif">
								  {!! Form::label('jenis_rumah_sakit', 'Jenis Rumah Sakit', ['class' => 'control-label']) !!}
								  {!! Form::select('jenis_rumah_sakit', $jenisRumahSakitOptions , null, ['class' => 'form-control']) !!}
								  @if($errors->has('jenis_rumah_sakit'))<code>{{ $errors->first('jenis_rumah_sakit') }}</code>@endif
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('tipe_rumah_sakit'))has-error @endif">
								  {!! Form::label('tipe_rumah_sakit', 'Tipe Rumah Sakit', ['class' => 'control-label']) !!}
								  {!! Form::select('tipe_rumah_sakit', $tipeRumahSakitOptions , null, ['class' => 'form-control']) !!}
								  @if($errors->has('tipe_rumah_sakit'))<code>{{ $errors->first('tipe_rumah_sakit') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('kode_pos'))has-error @endif">
								  {!! Form::label('kode_pos', 'Kode Pos', ['class' => 'control-label']) !!}
								  {!! Form::text('kode_pos' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('kode_pos'))<code>{{ $errors->first('kode_pos') }}</code>@endif
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('telepon'))has-error @endif">
								  {!! Form::label('telepon', 'Telepon', ['class' => 'control-label']) !!}
								  {!! Form::text('telepon' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('telepon'))<code>{{ $errors->first('telepon') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('fax'))has-error @endif">
								  {!! Form::label('fax', 'Fax', ['class' => 'control-label']) !!}
								  {!! Form::text('fax' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('fax'))<code>{{ $errors->first('fax') }}</code>@endif
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('email'))has-error @endif">
								  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
								  {!! Form::email('email' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('rayon_id'))has-error @endif">, <a href="{{ url('rayons/create') }}">tidak ada?</a>
								  {!! Form::label('rayon_id', 'Rayon', ['class' => 'control-label']) !!}
								  {!! Form::select('rayon_id', $rayonOptions , null, ['class' => 'form-control']) !!}
								  @if($errors->has('rayon_id'))<code>{{ $errors->first('rayon_id') }}</code>@endif
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('rayon_id'))has-error @endif">
								  {!! Form::label('bpjs', 'Melayani BPJS', ['class' => 'control-label']) !!}
								  {!! Form::select('bpjs', $termasukBpjsOptions , null, ['class' => 'form-control']) !!}
								  @if($errors->has('rayon_id'))<code>{{ $errors->first('rayon_id') }}</code>@endif
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
								<button class="btn btn-danger btn-block btn-lg hide" type="button" onclick="dummySubmit(this);return false;"></button>

								<a class="btn btn-danger btn-block btn-lg" href="{{ url('rumahsakits') }}">Cancel</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
@stop

