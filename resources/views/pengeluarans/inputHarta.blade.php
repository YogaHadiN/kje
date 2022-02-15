@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Input Harta

@stop
@section('page-title') 
<h2>Input Harta</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Input Harta</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Input Harta</div>
				</div>
				<div class="panel-body">
				
					{!! Form::open(['url' => 'pengeluarans/input_harta', 'method' => 'post']) !!}
						
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('harta'))has-error @endif">
								{!! Form::label('harta', 'Harta', ['class' => 'control-label']) !!}
								{!! Form::text('harta', null, array(
									'class'         => 'form-control rq'
								))!!}
							  @if($errors->has('harta'))<code>{{ $errors->first('harta') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('staf_id'))has-error @endif">
								{!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
								{!! Form::select('staf_id', App\Models\Staf::list(), null, array(
									'class'         => 'form-control selectpick rq',
									'data-live-search' => 'true'
								))!!}
							  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('harga'))has-error @endif">
								{!! Form::label('harga', 'Harga', ['class' => 'control-label']) !!}
								{!! Form::text('harga', null, array(
									'class'         => 'form-control uangInput rq'
								))!!}
							  @if($errors->has('harga'))<code>{{ $errors->first('harga') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('bulan_tahun_beli'))has-error @endif">
								{!! Form::label('bulan_tahun_beli', 'Bulan Tahun Pembelian', ['class' => 'control-label']) !!}
								{!! Form::text('bulan_tahun_beli', null, array(
									'class'         => 'form-control bulanTahun rq'
								))!!}
							  @if($errors->has('bulan_tahun_beli'))<code>{{ $errors->first('bulan_tahun_beli') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('status_harta_id'))has-error @endif">
								{!! Form::label('status_harta_id', 'Status Harta', ['class' => 'control-label']) !!}
								{!! Form::select('status_harta_id', App\Models\StatusHarta::list(), null, array(
									'class'         => 'form-control rq',
									'onchange'         => 'statusHartaChange(this);return false;',
								))!!}
							  @if($errors->has('status_harta_id'))<code>{{ $errors->first('status_harta_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row dijual hide">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('bulan_tahun_jual'))has-error @endif">
								{!! Form::label('bulan_tahun_jual', 'Bulan Tahun Dijual', ['class' => 'control-label']) !!}
								{!! Form::text('bulan_tahun_jual', null, array(
									'class'         => 'form-control bulanTahun'
								))!!}
							  @if($errors->has('bulan_tahun_jual'))<code>{{ $errors->first('bulan_tahun_jual') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('harga_jual'))has-error @endif">
								{!! Form::label('harga_jual', 'Harga Dijual', ['class' => 'control-label']) !!}
								{!! Form::text('harga_jual', null, array(
									'class'         => 'form-control uangInput'
								))!!}
							  @if($errors->has('harga_jual'))<code>{{ $errors->first('harga_jual') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('masa_pakai'))has-error @endif">
								{!! Form::label('masa_pakai', 'Perikiraan Masa Pakai', ['class' => 'control-label']) !!}
									<div class="input-group">
										{!! Form::text('masa_pakai', null, array(
											'class'         => 'form-control angka rq',
											'dir'         => 'rtl'
										))!!}
										<span class="input-group-addon">tahun</span>
									</div>
							  @if($errors->has('masa_pakai'))<code>{{ $errors->first('masa_pakai') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('metode_bayar_id'))has-error @endif">
								{!! Form::label('metode_bayar_id', 'metode_bayar_id', ['class' => 'control-label']) !!}
								{!! Form::select('metode_bayar_id', App\Models\MetodeBayar::list(), null, array(
									'class'         => 'form-control rq',
									'onchange'         => 'metodeBayar(this);return false;',
								))!!}
							  @if($errors->has('metode_bayar_id'))<code>{{ $errors->first('metode_bayar_id') }}</code>@endif
							</div>
						</div>

					</div>
					<div class="row cicil hide">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('uang_muka'))has-error @endif">
								{!! Form::label('uang_muka', 'Uang Muka', ['class' => 'control-label']) !!}
								{!! Form::text('uang_muka', null, array(
									'class'         => 'form-control uangInput'
								))!!}
							  @if($errors->has('uang_muka'))<code>{{ $errors->first('uang_muka') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('lama_cicilan'))has-error @endif">
								{!! Form::label('lama_cicilan', 'Lama Cicilan', ['class' => 'control-label']) !!}
								<div class="input-group">
									{!! Form::text('lama_cicilan', null, array(
										'class'         => 'form-control angka',
										'dir'         => 'rtl'
									))!!}
									<span class="input-group-addon">Tahun</span>
								</div>
							  @if($errors->has('lama_cicilan'))<code>{{ $errors->first('lama_cicilan') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('tax_amnesty'))has-error @endif">
								{!! Form::label('tax_amnesty', 'Tax Amnesty', ['class' => 'control-label']) !!}
								{!! Form::select('tax_amnesty', App\Models\Classes\Yoga::pilihan('Tax Amnesty'), null, array(
									'class'         => 'form-control rq'
								))!!}
							  @if($errors->has('tax_amnesty'))<code>{{ $errors->first('tax_amnesty') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
							{!! Form::submit('Submit', ['class' => 'btn btn-success hide submit']) !!}
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
						<div class="panel-title">Data Input Harta</div>
					</div>
					<div class="panelRight">
					</div>
				</div>
				<div class="panel-body">
					  <div class="table-responsive">
						  <div class="table-responsive">
							<table class="table table-hover table-bordered table-condensed">
								<thead>
									<tr>
										<th>Harta</th>
										<th>Harga Beli</th>
										<th>Penyusutan</th>
										<th>Status Harta</th>
										<th>Tax Amnesty</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach( $hartas as $harta )
										<tr>
											<td>{{ $harta->harta }}</td>
											<td>{{ App\Models\Classes\Yoga::buatrp( $harta->harga)}} </td>
											<td>{{App\Models\Classes\Yoga::buatrp ( $harta->penyusutan )}} </td>
											<td>{{ $harta->statusHarta->status_harta}} </td>
											<td>{{ App\Models\Classes\Yoga::yesNo($harta->tax_amnesty) }} </td>
											<td> <a class="btn btn-warning" href="{{ url('pengeluarans/input_harta/show/' . $harta->id) }}">Detail</a> </td>
										</tr>
									@endforeach
								</tbody>
							</table>
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
			$(control).closest('form').find('.submit').click();
		}
	}
	var base = "{{ url('/') }}";
	function metodeBayar(control){
		if( $(control).val() == '2' ){
			clearFormInput('.cicil');
			$('.cicil').removeClass('hide').hide().slideDown(500);
		} else {
			$('.cicil').slideUp(500, function(){
				clearFormInput('.cicil');
			});
		}
	}
	function statusHartaChange(control){
		if( $(control).val() == '2' ){
			clearFormInput('.dijual');
			$('.dijual').removeClass('hide').hide().slideDown(500);
		} else {
			$('.dijual').slideUp(500, function(){
				clearFormInput('.dijual');
			});
		}
	}
	function clearFormInput(control){
		$(control).find('input').val('');
		$(control).find('select').each(function(){
			$(this).val('');
			if( $(this).hasClass('selectpick') ){
				$(this).selectpicker('refresh');
			}
		});
		$(control).find('textarea').val('');
	}

 </script>
@stop
