@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Buat Laporan Pajak

@stop
@section('page-title') 
<h2>Laporan Pajak</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li>
		  <a href="{{ url('pajaks/lapor_pajaks')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Pajak</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					Buat Laporan Pajak
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						{!! Form::open([
							'url' => 'pajaks/lapor_pajaks',
							"class" => "m-t", 
							"role"  => "form",
							"method"=> "post",
							"files"=> "true"
						]) !!}
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('staf_id'))has-error @endif">
									  {!! Form::label('staf_id', 'Nama Staf', ['class' => 'control-label']) !!}
										{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
											'class'            => 'form-control selectpick',
											'data-live-search' => 'true',
											'placeholder'      => '- Pilih Staf -'
										))!!}
									  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('tanggal_lapor'))has-error @endif">
									  {!! Form::label('tanggal_lapor', 'Tanggal Laporan', ['class' => 'control-label']) !!}
										{!! Form::text('tanggal_lapor',  null, array(
											'class'         => 'form-control tanggal'
										))!!}
									  @if($errors->has('tanggal_lapor'))<code>{{ $errors->first('tanggal_lapor') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row row_periode">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
									<div class="form-group @if($errors->has('awal_periode'))has-error @endif">
									  {!! Form::label('periode', 'Periode', ['class' => 'control-label']) !!}
										{!! Form::text('periode',  null, array(
											'id'         => 'periode',
											'class'         => 'form-control periode'
										))!!}
									  @if($errors->has('periode'))<code>{{ $errors->first('periode') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('jenis_pajak_id'))has-error @endif">
									  {!! Form::label('jenis_pajak_id', 'Jenis Pajak', ['class' => 'control-label']) !!}
									  {!! Form::select('jenis_pajak_id', App\Models\JenisPajak::list(), null, array(
											'class'       => 'form-control',
											'onchange'    => 'jenisPajakChange(this);return false',
											'placeholder' => '- Pilih Jenis Pajak -',
									  ))!!}
									  @if($errors->has('jenis_pajak_id'))<code>{{ $errors->first('jenis_pajak_id') }}</code>@endif
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('periode'))has-error @endif">
									  {!! Form::label('periode', 'Periode', ['class' => 'control-label label-periode-pajak']) !!}
										{!! Form::text('periode',  null, array(
											'class'       => 'form-control',
											'id'          => 'periodePajak',
											'placeholder' => 'Periode Pajak'
										))!!}
									  @if($errors->has('periode'))<code>{{ $errors->first('periode') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('nilai'))has-error @endif">
									  {!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
										{!! Form::text('nilai',  null, array(
											'class'         => 'form-control uangInput',
											'dir'         => 'rtl'
										))!!}
									  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									@if(isset($lapor_pajak))
										<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
									@else
										<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
									@endif
									{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a class="btn btn-danger btn-block" href="{{ url('pajaks/lapor_pajaks') }}">Cancel</a>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group{{ $errors->has('dokumen_dan_bukti') ? ' has-error' : '' }}">
									{!! Form::label('dokumen_dan_bukti', 'Upload Dokumen dan Bukti', ['class' => 'control-label']) !!}
									{!! Form::file('dokumen_dan_bukti', ['class' => 'form-control']) !!}
									{!! $errors->first('dokumen_dan_bukti', '<p class="help-block">:message</p>') !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
@stop
@section('footer') 
	{!! HTML::script('js/lapor_pajak_create.js')!!}
@stop
