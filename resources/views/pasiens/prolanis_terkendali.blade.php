@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Prolanis Terkendali

@stop
@section('page-title') 
<h2>Laporan Prolanis Terkendali</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Prolanis Terkendali</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Laporan Per Bulan</h3>
					</div>
					<div class="panel-body">
						{!! Form::open(['url' => 'pasiens/prolanis_terkendali/per_bulan', 'method' => 'post']) !!}
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('bulan'))has-error @endif">
									  {!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
										{!! Form::select('bulan', App\Models\Classes\Yoga::bulanList(), null, array(
											'class'         => 'form-control rq'
										))!!}
									  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group @if($errors->has('tahun'))has-error @endif">
										  {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
											{!! Form::select('tahun', App\Models\Classes\Yoga::tahunList(), null, array(
												'class'         => 'form-control request'
											))!!}
										  @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
										</div>
									</div>
								</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
											{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
										</div>
									</div>
							
						{!! Form::close() !!}
					</div>
				</div>
				
			</div>
		</div>
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
@stop
