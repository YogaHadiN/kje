@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Janji Kontrol

@stop
@section('page-title') 
<h2>Edit Janji Kontrol</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Janji Kontrol</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Edit Janji Kontrol</div>
				</div>
				<div class="panel-body">
				{!! Form::open(['url' => 'kontrols/' . $kontrol->id, 'method' => 'put']) !!}
					@include('kontrols.form', ['tanggal' => $kontrol->tanggal->format('d-m-Y')])
				{!! Form::close() !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!! Form::open(['url' => 'kontrols/' . $kontrol->id, 'method' => 'delete']) !!}
						{!! Form::text('periksa_id', $kontrol->periksa_id, ['class' => 'form-control hide']) !!}
							{!! Form::submit('DELETE',[
								'class' => 'btn btn-danger btn-lg btn-block', 
								'onclick' => 'return confirm("Apa Anda Yakin mau membatalakan Janji Kontrol Pasien ini?"); return false;'
							]) !!}
						{!! Form::close() !!}
					</div>
				</div>
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

