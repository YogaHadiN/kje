@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Cek Pulsa Harian

@stop
@section('page-title') 
<h2>Cek Pulsa Harian</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cek Pulsa Harian</strong>
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
					{!! Form::open(['url' => 'cek_list_harian/listrik', 'method' => 'post']) !!}
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
								{!! Form::label('staf_id', 'Staf', ['class' => 'control-label']) !!}
								{!! Form::select('staf_id', App\Models\Staf::list(),  null, array(
									'class'            => 'form-control selectpick rq',
									'data-live-search' => 'true'
								))!!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('listrik_A6'))has-error @endif">
								{!! Form::label('listrik_A6', 'Listrik A6', ['class' => 'control-label']) !!}
								<div class="input-group">
									{!! Form::text('listrik_A6', null, array(
										'class'         => 'form-control angka rq',
										'dir'         => 'rtl'
									))!!}
								  <span class="input-group-addon">KwH</span>
								</div>
								
							  @if($errors->has('listrik_A6'))<code>{{ $errors->first('listrik_A6') }}</code>@endif
							</div>
						</div>
					</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group @if($errors->has('listrik_A7'))has-error @endif">
										{!! Form::label('listrik_A7', 'Listrik A7', ['class' => 'control-label']) !!}
										<div class="input-group">
											{!! Form::text('listrik_A7', null, array(
												'class'         => 'form-control angka rq',
												'dir'         => 'rtl'
											))!!}
										  <span class="input-group-addon">KwH</span>
										</div>
										
									  @if($errors->has('listrik_A7'))<code>{{ $errors->first('listrik_A7') }}</code>@endif
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group @if($errors->has('listrik_A8'))has-error @endif">
										{!! Form::label('listrik_A8', 'Listrik A8', ['class' => 'control-label']) !!}
										<div class="input-group">
											{!! Form::text('listrik_A8', null, array(
												'class'         => 'form-control angka rq',
												'dir'         => 'rtl'
											))!!}
										  <span class="input-group-addon">KwH</span>
										</div>
										
									  @if($errors->has('listrik_A8'))<code>{{ $errors->first('listrik_A8') }}</code>@endif
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
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Cek Listrik</div>
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
									<th>Jam</th>
									<th>Staf</th>
									<th>Listrik A6</th>
									<th>Listrik A7</th>
									<th>Listrik A8</th>
								</tr>
							</thead>
							<tbody>
								@if($cek_listriks->count() > 0)
									@foreach( $cek_listriks as $cl )
										<tr>
											<td>{{ $cl->created_at->format('d-m-Y') }}</td>
											<td>{{ $cl->created_at->format('H:i:s') }}</td>
											<td>{{ $cl->staf->nama }}</td>
											<td class="text-right">{{ $cl->listrik_a6 }} Kwh</td>
											<td class="text-right">{{ $cl->listrik_a7 }} Kwh</td>
											<td class="text-right">{{ $cl->listrik_a8 }} Kwh</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="5">Tidak ada data untuk ditampilkan</td>
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
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
@stop
