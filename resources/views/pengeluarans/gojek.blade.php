@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Transaksi Gojek
@stop
@section('page-title') 
<h2>Transaksi Gojek</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Transaksi Gojek</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Transaksi Gojek</div>
					</div>
					<div class="panelRight">
						  Panel Right
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<div>
							  <ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#pulsa_keluar" aria-controls="pulsa_keluar" role="tab" data-toggle="tab">Pakai Gojek</a></li>
								<li role="presentation"><a href="#pulsa_masuk" aria-controls="pulsa_masuk" role="tab" data-toggle="tab">Bayar Go Pay</a></li>
							  </ul>
							  <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="pulsa_keluar">
									{!! Form::open(['url' => 'pengeluarans/gojek/pakai', 'method' => 'post']) !!}
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('tujuan'))has-error @endif">
													{!! Form::label('tujuan', 'Tujuan', ['class' => 'control-label']) !!}
													{!! Form::textarea('tujuan', null, array(
														'class'         => 'form-control textareacustom'
													))!!}
												  @if($errors->has('tujuan'))<code>{{ $errors->first('tujuan') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('nilai'))has-error @endif">
													{!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
													{!! Form::text('nilai', null, array(
														'class'         => 'form-control uangInput'
													))!!}
												  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('tanggal'))has-error @endif">
													{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
													{!! Form::text('tanggal', date('d-m-Y'), array(
														'class'         => 'form-control tanggal'
													))!!}
												  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('staf_id'))has-error @endif">
													{!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
													{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
														'class'         => 'form-control selectpick',
														'data-live-search' => 'true'
													))!!}
												  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
												{!! Form::submit('Submit', ['class' => 'btn btn-success hide submit']) !!}
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<a class="btn btn-danger btn-block" href="{{ url('belanjalist') }}">Cancel</a>
											</div>
										</div>
									{!! Form::close() !!}
								</div>
								<div role="tabpanel" class="tab-pane" id="pulsa_masuk">
									{!! Form::open(['url' => 'pengeluarans/gojek/tambah/gopay', 'method' => 'post']) !!}
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('nilai'))has-error @endif">
													{!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
													{!! Form::text('nilai', null, array(
														'class'         => 'form-control uangInput'
													))!!}
												  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('sumber_uang_id'))has-error @endif">
													{!! Form::label('sumber_uang_id', 'Sumber Uang', ['class' => 'control-label']) !!}
													{!! Form::select('sumber_uang_id', App\Models\Classes\Yoga::sumberuang(), null, array(
														'class'         => 'form-control '
													))!!}
												  @if($errors->has('sumber_uang_id'))<code>{{ $errors->first('sumber_uang_id') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('tanggal'))has-error @endif">
													{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
													{!! Form::text('tanggal', date('d-m-Y'), array(
														'class'         => 'form-control tanggal'
													))!!}
												  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('staf_id'))has-error @endif">
													{!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
													{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
														'class'         => 'form-control selectpick',
														'data-live-search' => 'true'
													))!!}
												  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
												{!! Form::submit('Submit', ['class' => 'btn btn-success hide submit']) !!}
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<a class="btn btn-danger btn-block" href="{{ url('belanjalist') }}">Cancel</a>
											</div>
										</div>
									{!! Form::close() !!}
								</div>
							  </div>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div>
								<img src="{{ \Storage::disk('s3')->url('img/gojek.png') }}" class="img-round full-width" alt="Responsive image">
							</div>
							<div class="alert alert-info">
								<h3>PERHATIAN</h3>
								<p>Fitur ini hanya digunakan untuk transaksi Go Jek yang menggunakan Go Pay</p>
								<p>Selain dari itu mohon untuk menggunakan fitur Belanja Bukan Obat</p>
							</div>
							<div class="alert alert-danger">
								<p>Fitur Pakai Gojek mengurangi pulsa Go Pay</p>
								<p>Fitur Bayar Go Pay menambah pulsa Go Pay</p>
								<h3>Jangan sampai tertukar</h3>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="panelLeft">
							<h3>
								Data Transaksi
							</h3>
						</div>
						<div class="panelLeft">
							<h3 class="text-right">
								Total : {{ App\Models\Classes\Yoga::buatrp( $total ) }}
							</h3>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<?php echo $ggs->appends(Input::except('page'))->links(); ?>
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Bertambah</th>
									<th>Berkurang</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($ggs->count() > 0)
									@foreach( $ggs as $gg )
										<tr>
										<td>{{ $gg->tanggal->format( 'd M Y' ) }}</td>
										<td>{{ $gg->keterangan }}</td>
										@if( $gg->debit )
											<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $gg->nilai  )}}</td>
										@else
											<td></td>
										@endif
										@if( !$gg->debit )
											<td class="text-right">{{App\Models\Classes\Yoga::buatrp( $gg->nilai ) }}</td>
										@else
											<td></td>
										@endif
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
					<?php echo $ggs->appends(Input::except('page'))->links(); ?>
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2()){
				$(control).closest('div').find('.submit').click();
			}
		}
	</script>
@stop
