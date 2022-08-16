@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Daftar Pasien Baru Melalui Facebook

@stop
@section('page-title') 
<h2>Daftar Pasien Baru Melalui Facebook</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Pasien Baru Melalui Facebook</strong>
	  </li>
</ol>

@stop
@section('content') 

{!! Form::model($fb, [
	'url' => 'facebook/input_pasien_baru/'.$fb->id, 
	'files' => 'true', 
	'method' => 'post'
]) !!}
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Isian Pendaftaran</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group @if($errors->has('antrian'))has-error @endif">
							{!! Form::label('antrian', 'Antrian', ['class' => 'control-label']) !!}
						  {!! Form::text('antrian' , $antrian, ['class' => 'form-control angka rq']) !!}
						  @if($errors->has('antrian'))<code>{{ $errors->first('antrian') }}</code>@endif
						</div>
					</div>
					<div class="hide col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<div class="form-group @if($errors->has('poli'))has-error @endif">
							{!! Form::label('poli', 'Poli', ['class' => 'control-label']) !!}
						  {!! Form::select('poli' , App\Models\Classes\Yoga::poliList(), $fb->pilihan_poli, ['class' => 'form-control rq selectpick', 'data-live-search' => 'true']) !!}
						  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Buat Pasien Baru</div>
			</div>
			<div class="panel-body">
					@include('pasiens.modal_insert', ['rq' => true])	
					 <div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
								{!! Form::label('bpjs_image', 'Foto Kartu BPJS', ['class' => 'control-label']) !!}
								{!! Form::file('bpjs_image', ['class' => 'form-control']) !!}
								@if (isset($pasien) && $pasien->bpjs_image)
									<p> <img src="{{ \Storage::disk('s3')->url($pasien->bpjs_image) }}" alt="" class="img-rounded"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded"> </p>
								@endif
								{!! $errors->first('bpjs_image', '<p class="help-block">:message</p>') !!}

							</div>
						</div>
					 </div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
								{!! Form::label('ktp_image', 'Foto KTP', ['class' => 'control-label']) !!}
								{!! Form::file('ktp_image', ['class' => 'form-control']) !!}
								@if (isset($pasien) && $pasien->ktp_image)
									<p> <img src="{{ \Storage::disk('s3')->url($pasien->ktp_image) }}" alt="" class="img-rounded"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded"> </p>
								@endif
								{!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
							</div>
						</div>
					 </div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false">Submit</button>
							{!! Form::submit('submit', [
								'class' => 'hide',
								'id' => 'submit'							
							]) !!}
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-danger btn-block btn-lg" href="{{ url('facebook/list') }}">Cancel</a>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	</script>
	{!! HTML::script('js/togglepanel.js')!!}
	{{ HTML::script('js/pasiens.js') }}
	<script type="text/javascript" charset="utf-8">

		$(function () {
			if($('#CheckBox1').attr('checked') == 'true'){
				$('#xx').show();
			}
			if({{ $fb->pilihan_pembayaran }} != 0){
				$('#CheckBox1').prop('checked', true);
				isChecked();
			}
			$('#CheckBox1').change(function() {
				if(this.checked) {
					isChecked();
				}else{
					isUnchecked();
				}
			});


		});
		function dummySubmit(){
			
			if(validatePass()){
				$('#submit').click();
			}
		}
		function isChecked(){
			$('#xx').show();
			$('#asuransi_id').addClass('rq');
			$('#jenis_peserta').addClass('rq');
			$('#nomor_asuransi').addClass('rq');
			$('#nama_peserta').addClass('rq');
		}
		function isUnchecked(){
			$('#xx').hide();
			$('#asuransi_id').removeClass('rq');
			$('#jenis_peserta').removeClass('rq');
			$('#nomor_asuransi').removeClass('rq');
			$('#nama_peserta').removeClass('rq');
		}
	</script>
@stop


