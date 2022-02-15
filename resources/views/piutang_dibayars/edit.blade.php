@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Pembayaran Piutang

@stop
@section('page-title') 
<h2>Edit Pembayaran Piutang</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Pembayaran Piutang</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Piutang </h3>
				</div>
				<div class="panel-body">
					{!! Form::model($piutang_dibayar, ['url' => 'piutang_dibayars/' . $piutang_dibayar->id, 'method' => 'put']) !!}
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered">


								<tbody>
									<tr>
										<td>Nama Pasien</td>
										<td>{{ $piutang_dibayar->periksa->pasien->nama }}</td>
									</tr>
									<tr>
										<td>Pemeriksaan Tanggal</td>
										<td>
											<a class="" href="{{ url('periksas/' . $piutang_dibayar->periksa_id) }}">
												{{ date('d M Y', strtotime( $piutang_dibayar->periksa->created_at )) }}
											</a>
										</td>
									</tr>
									<tr>
										<td>Pembayaran Tanggal</td>
										<td>
											<a class="" href="{{ url('pembayaran_asuransis/' . $piutang_dibayar->pembayaran_asuransi_id) }}">
												{{ date('d M Y', strtotime( $piutang_dibayar->pembayaranAsuransi->created_at )) }}
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
							
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('pembayaran'))has-error @endif">
								  {!! Form::label('pembayaran', 'Pembayaran', ['class' => 'control-label']) !!}
									{!! Form::text('pembayaran', null, array(
										'class'         => 'form-control rq'
									))!!}
								  @if($errors->has('pembayaran'))<code>{{ $errors->first('pembayaran') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								@if(isset($update))
									<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
								@else
									<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
								@endif
								{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
							</div>
					{!! Form::close() !!}
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

								{!! Form::open(['url' => 'piutang_dibayars/' .$piutang_dibayar->id, 'method' => 'delete']) !!}
								{!! Form::submit('Delete', [
									'class'   => 'btn btn-danger btn-block',
									'onclick' => 'return confirm("Anda yakin mau menghapus ' . $piutang_dibayar->id . '-' . $piutang_dibayar->name.'?");return false;'
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
	function dummySubmit(control){
		if(validatePass2(control)){
			$('#submit').click();
		}
	}
</script>
@stop

