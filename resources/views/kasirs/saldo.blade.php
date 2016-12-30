@extends('layout.master')

@section('title') 
Klinik Jati Elok | Hitung Saldo

@stop
@section('page-title') 
<h2>Hitung Saldo</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Hitung Saldo</strong>
	  </li>
</ol>

@stop
@section('content') 
		{!! Form::open(['url' => 'kasirs/saldo', 'method' => 'post']) !!}
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">Hitung Saldo</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('saldo'))has-error @endif">
							  {!! Form::label('saldo', 'Saldo Saat Ini', ['class' => 'control-label']) !!}
							  {!! Form::text('saldo' , null, ['class' => 'form-control uangInput rq']) !!}
							  @if($errors->has('saldo'))<code>{{ $errors->first('saldo') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
							  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
							  {!! Form::select('staf_id' , App\Staf::list(), null, ['class' => 'form-control rq selectpick', 'data-live-search' => 'true']) !!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Submit</button>
								{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
							</div> 
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
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
						<div class="panel-title">Riwayat Saldo</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered">
								<thead>
									<tr>
										<th>Waktu</th>
										<th>Saldo</th>
										<th>Staf</th>
										@if( \Auth::id() == '28' )
											<th>Saldo Saat Ini</th>
											<th>Selisih</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@if($saldos->count() > 0)
										@foreach($saldos as $s)
											<tr>
												<td>{{ $s->created_at->format('d M Y H:i:s') }}</td>
												<td class='uang'>{{ $s->saldo }}</td>
												<td class='uang'>{{ $s->staf->nama }}</td>
												@if( \Auth::id() == '28' )
													<td class='uang'>{{ $s->saldo_saat_ini }}</td>
													<td class='uang'>{{ $s->selisih }}</td>
												@endif
											</tr>
										@endforeach
									@else
										<tr>
												@if( \Auth::id() == '28' )
													<td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
												@else
													<td class="text-center" colspan="3">Tidak Ada Data Untuk Ditampilkan :p</td>
												@endif
										</tr>
									@endif
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
				
			</div>
			
		{!! Form::close() !!}
	</div>
	
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
	function dummySubmit(){
		if(validatePass()){
			$('#submit').click();
		}
	}
</script>
@stop

