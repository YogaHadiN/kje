@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Janji Kontrol

@stop
@section('page-title') 
<h2>Buat Janji Kontrol</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Janji Kontrol</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Buat Janji Kontrol</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'kontrols', 'method' => 'post']) !!}
					@include('kontrols.form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
			var date = new Date();
			date.setDate(date.getDate()+1);
            $('#tanggal').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'dd-mm-yyyy',
				startDate: date
            });
	</script>
@stop

