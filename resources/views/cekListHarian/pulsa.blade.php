@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Cek List Harian

@stop
@section('page-title') 
<h2>Cek List Harian</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cek List Harian</strong>
	  </li>
	<li class="active">
		  <strong>Pulsa</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Cek List Harian</div>
					</div>
					<div class="panelRight">
					  
					</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'cek_list_harian/pulsa', 'method' => 'post']) !!}
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
								{!! Form::label('staf_id', 'Staf', ['class' => 'control-label']) !!}
								{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
									'class'            => 'form-control rq selectpick',
									'data-live-search' => 'true'
								))!!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('merek'))has-error @endif">
								{!! Form::label('pulsa_zenziva', 'Pulsa Zenziva', ['class' => 'control-label']) !!}
								<div class="input-group">
									{!! Form::text('pulsa_zenziva',  null, array(
										'class' => 'form-control rq angka',
										'dir'   => 'rtl'
									))!!}
									  <span class="input-group-addon">SMS</span>
								</div>
							  @if($errors->has('pulsa_zenziva'))<code>{{ $errors->first('pulsa_zenziva') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('expired_zenziva'))has-error @endif">
								{!! Form::label('expired_zenziva', 'Kadaluarsa Zenziva', ['class' => 'control-label']) !!}
								{!! Form::text('expired_zenziva', null, array(
									'class'         => 'form-control tanggal rq'
								))!!}
							  @if($errors->has('expired_zenziva'))<code>{{ $errors->first('expired_zenziva') }}</code>@endif
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('pulsa_gammu'))has-error @endif">
								{!! Form::label('pulsa_gammu', 'Pulsa Gammu', ['class' => 'control-label']) !!}
								{!! Form::text('pulsa_gammu',  null, array(
									'class' => 'form-control rq uangInput',
								))!!}
							  @if($errors->has('pulsa_gammu'))<code>{{ $errors->first('pulsa_gammu') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('expired_gammu'))has-error @endif">
								{!! Form::label('expired_gammu', 'Kadaluarsa Gammu', ['class' => 'control-label']) !!}
								{!! Form::text('expired_gammu', null, array(
									'class'         => 'form-control tanggal rq'
								))!!}
							  @if($errors->has('expired_gammu'))<code>{{ $errors->first('expired_gammu') }}</code>@endif
							</div>
						</div>
					</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button class="btn btn-success btn-block" type="button" onclick='dummySubmit();return false;'>Submit</button>
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
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Cek Pulsa Harian</div>
					</div>
					<div class="panelRight">
					  
					</div>
				</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Staf</th>
								<th>Pulsa Zenziva</th>
								<th>Pulsa Gammu</th>
							</tr>
						</thead>
						<tbody>
							@if($cek_pulsas->count() > 0)
								@foreach( $cek_pulsas as $cp )
									<tr>
										<td>{{ $cp->created_at->format('d-m-Y')  }} <br /> {{ $cp->created_at->format('H:i:s') }} </td>
										<td>{{ $cp->staf->nama }}</td>
										<td class="text-right">{{ $cp->pulsa_zenziva }} SMS <br />	{{ $cp->expired_zenziva->format('d-m-Y') }} </td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $cp->pulsa_gammu ) }}
															<br />	{{ $cp->expired_gammu->format('d-m-Y') }} 
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="4">Tidak ada data untuk ditampilkan</td>
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
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass2()){
				$('#submit').click();
			}
		}
	</script>
@stop
