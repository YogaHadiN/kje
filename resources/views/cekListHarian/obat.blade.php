@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Cek Obat Harian

@stop
@section('page-title') 
<h2>Cek Obat Harian</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cek Obat Harian</strong>
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
					{!! Form::open(['url' => 'cek_list_harian/obat', 'method' => 'post']) !!}
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
								{!! Form::label('staf_id', 'Staf', ['class' => 'control-label']) !!}
								{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
									'class'         => 'form-control selectpick rq',
									'data-live-search'         => 'true'
								))!!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
					</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('merek'))has-error @endif">
									{!! Form::label('merek', 'Merek', ['class' => 'control-label']) !!}
									{!! Form::select('merek', App\Models\Merek::list(), null, array(
										'class'            => 'rq selectpick form-control',
										'data-live-search' => 'true'
									))!!}
								  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('jumlah_merek'))has-error @endif">
									{!! Form::label('jumlah', 'Jumlah Merek', ['class' => 'control-label']) !!}
									{!! Form::text('jumlah',  null, array(
										'class'            => 'form-control',
									))!!}
								  @if($errors->has('jumlah_merek'))<code>{{ $errors->first('jumlah_merek') }}</code>@endif
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
	 @if(Auth::id() == '28' || Auth::id() == '3003' || Auth::id() == '3010')
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panelLeft">
							<div class="panel-title">Cek Obat</div>
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
										<th>Rak ID</th>
										<th>Staf</th>
										<th>Merek</th>
										<th>Jumlah di Sistem</th>
										<th>Jumlah di Hitung</th>
										<th>Selisih</th>
									</tr>
								</thead>
								<tbody>
									@if($cek_obats->count() > 0)
										@foreach( $cek_obats as $co )
											<tr 
												 @if( $co->jumlah_di_hitung - $co->jumlah_di_sistem  > 0  )
													class="success"
												 @elseif(  $co->jumlah_di_hitung - $co->jumlah_di_sistem  < 0   )
													class="danger"
												 @endif
											>
												<td>
													{{ $co->created_at->format('d-m-Y') }} <br /> 
													{{ $co->created_at->format('H:i:s') }}
												</td>

                                                <td>{{ $co->rak->kode_rak }}</td>
												<td>{{ $co->staf->nama }}</td>
												<td>
													<ul>
														@foreach(  $co->rak->merek  as $m )
															<li>{{ $m->merek }}</li>
														@endforeach
													</ul>
												</td>
												<td class="text-right">{{ $co->jumlah_di_sistem }}</td>
												<td class="text-right">{{ $co->jumlah_di_hitung }}</td>
												<td class="text-right">
													<strong>{{ $co->jumlah_di_hitung - $co->jumlah_di_sistem  }}</strong>	
												</td>
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
	@endif
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
