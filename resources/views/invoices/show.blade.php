@extends('layout.master')

@section('title') 
Klinik Jati Elok | Piutang Asuransi

@stop
@section('page-title') 
<h2>Piutang Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Piutang Asuransi</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{ $invoice->id }} ({{ $invoice->periksa->first()->asuransi->nama }})
		</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama Pasien</th>
						<th>Nomor Asuransi</th>
						<th>Piutang</th>
						<th>Tunai</th>
						<th>Tagihan</th>
						<th>Sudah Dibayar</th>
						<th>Sisa piutang</th>
					</tr>
				</thead>
				<tbody>
					@if($invoice->periksa->count() > 0)
						@foreach($invoice->periksa as $piutang)
							<tr>
								<td>
									<a href="{{ url('periksas/' . $piutang->id ) }}" target="_blank">
										{{ $piutang->tanggal }}
									</a>
								</td>
								<td>
									<a href="{{ url('pasiens/' . $piutang->pasien_id . '/edit') }}" target="_blank">
										{{ $piutang->pasien->nama }}
									</a>
								</td>
								<td>{{ $piutang->nomor_asuransi }}</td>
								<td class="uang">{{ $piutang->piutang }}</td>
								<td class="uang">{{ $piutang->tunai }}</td>
								<td class="uang">{{ $piutang->piutang - $piutang->tunai }}</td>
								<td class="uang">{{ $piutang->sudah_dibayar }}</td>
								<td class="uang">{{ $piutang->piutang  - $piutang->sudah_dibayar }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="8" class="text-center">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Upload Validasi Penerimaan</h3>
				</div>
				<div class="panel-body">
					{!! Form::open([
						'url'    => 'invoices/upload_verivication/' . str_replace('/', '!',  $invoice->id ),
						'method' => 'post',
						"class"  => "m-t",
						"role"   => "form",
						"files"  => "true"
					]) !!}
						<div class="form-group{{ $errors->has('received_verification') ? ' has-error' : '' }}">
							{!! Form::label('received_verification', 'Upload Validasi Penerimaan Berkas') !!}
							{!! Form::file('received_verification') !!}
								@if (isset($invoice) && $invoice->received_verification)
									<p>
										<a href="{{ \Storage::disk('s3')->url($invoice->received_verification ) }}" target="_blank">
											<img src="{{ \Storage::disk('s3')->url($invoice->received_verification ) }}" class="upload" alt="...">
										</a>
									</p>
								@else
									<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
								@endif
							{!! $errors->first('received_verification', '<p class="help-block">:message</p>') !!}
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

