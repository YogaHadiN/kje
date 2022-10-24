@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Pph21

@stop
@section('page-title') 
<h2>Pph21</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pph21</strong>
	  </li>
</ol>

@stop
@section('content') 
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Pilih Bulan Dan Tahun</h3>
			</div>
			<div class="panel-body">
				{!! Form::open(['url' => 'pajaks/pph21s/perBulan', 'method' => 'get']) !!}
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('bulan'))has-error @endif">
							  {!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
								{!! Form::select('bulan', App\Models\Classes\Yoga::bulanList(), null, array(
									'class'         => 'form-control',
									'placeholder'         => '- Pilih Bulan -'
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
									'class'         => 'form-control',
									'placeholder'         => '- Pilih Tahun -'
								))!!}
							  @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
							{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-danger btn-block" href="{{ url('laporans') }}">Cancel</a>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
				</div>
			</div>
		{{-- <div class="table-responsive"> --}}
		{{-- 	<table class="table table-hover table-condensed table-bordered"> --}}
		{{-- 		<thead> --}}
		{{-- 			<tr> --}}
		{{-- 				<th>Tanggal</th> --}}
		{{-- 				<th>Nama</th> --}}
		{{-- 				<th>Gaji Pokok</th> --}}
		{{-- 				<th>Bonus</th> --}}
		{{-- 				<th>Pph21</th> --}}
		{{-- 				<th>Action</th> --}}
		{{-- 			</tr> --}}
		{{-- 		</thead> --}}
		{{-- 		<tbody> --}}
		{{-- 			@foreach($datas as $pph) --}}
		{{-- 				<tr> --}}
		{{-- 					<td>{{ $pph['bulanTahun'] }}</td> --}}
		{{-- 					<td>{{ $pph['nama'] }}</td> --}}
		{{-- 					<td class="text-right uang">{{ $pph['gaji_pokok'] }}</td> --}}
		{{-- 					<td class="text-right uang">{{ $pph['bonus'] }}</td> --}}
		{{-- 					<td class="text-right uang">{{ $pph['pph21'] }}</td> --}}
		{{-- 					<td nowrap class="autofit"> --}}
		{{-- 						<a href="{{ url('pajaks/pph21s/'. $pph['staf_id'] . '/' . $pph['bulanTahun']) }}" class="btn btn-info btn-sm btn-block" target="_blank">Detil</a> --}}
		{{-- 					</td> --}}
		{{-- 				</tr> --}}
		{{-- 			@endforeach --}}
		{{-- 		</tbody> --}}
		{{-- 	</table> --}}
		{{-- </div> --}}
		
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
