 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | sign Up

 @stop
 @section('head')

    <link href="{{ url('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
 @stop

 @section('page-title') 

 <h2>Pasien Baru</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li class="active">
          <strong>Pasien Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
{!! Form::open(array(
	"url"   => "pasiens",
	"class" => "m-t", 
	"role"  => "form",
	"files"  => "true",
	"method"=> "post"
))!!}
 <div class="row">
	<div class="panel panel-info">
		<div class="panel-body">
			 <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
				 <div class="row">
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					@include('pasiens.modal_insert', ['facebook' => false])    
				 	</div>
				 </div>
			</div>
			 <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
							 {!! Form::label('ktp_image', 'Upload Gambar KTP') !!}
							 {!! Form::file('ktp_image') !!}
							 @if (isset($pasien) && $pasien->ktp_image)
								 <p> {!! HTML::image(asset('img/pasien/'.$pasien->ktp_image), null, ['class'=>'img-rounded upload']) !!} </p>
							 @else
								 <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
							 @endif
							 {!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
							 {!! Form::label('bpjs_image', 'Upload Kartu BPJS') !!}
							 {!! Form::file('bpjs_image') !!}
							 @if (isset($pasien) && $pasien->bpjs_image)
								 <p> {!! HTML::image(asset('img/pasien/'.$pasien->bpjs_image), null, ['class'=>'img-rounded upload']) !!} </p>
							 @else
								 <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
							 @endif
							 {!! $errors->first('bpjs_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
			</div>
		 </div>
		 <div class="panel-footer">
		 	<div class="row">
		 		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 			<button class="btn btn-success btn-lg btn-block" type="submit"> Submit </button>
		 		</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-danger btn-lg btn-block" href="{{ url('pasiens') }}">Cancel</a>
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
	{!! HTML::script('js/plugins/webcam/photo.js')!!}
	{!! HTML::script('js/togglepanel.js')!!}
	{!! HTML::script('js/pasiens.js')!!}
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
    });
</script>

 @stop


       
