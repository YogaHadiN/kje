@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftarkan Pasien

@stop
@section('page-title') 
<h2>Daftarkan Pasien</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Daftarkan Pasien</strong>
            </li>
</ol>

@stop
@section('content') 
	{!! Form::open(['url' => 'antrianpolis/' . $antrian->id .'/daftarkan', 'method' => 'post']) !!}
	<div class="row">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
             <img src="{{ \Storage::disk('s3')->url( $pasien->image ) }}" alt="" class="img-rounded upload"> 
		</div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group @if($errors->has('nama')) has-error @endif">
					  {!! Form::label('nama', 'Nama Pasien', ['class' => 'control-label']) !!}
                      {!! Form::text('nama' , $pasien->nama , ['class' => 'form-control']) !!}
					  @if($errors->has('nama'))<code>{!! $errors->first('nama') !!}</code>@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Poli:</label>
						{!! Form::select('poli_id', $poli, null, [
							'id' => 'antrianpoli_poli', 
							'class' => 'form-control rq', 
							'placeholder' => '- Pilih Poli -'
						])!!}
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Dokter  </label>
						{!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id'), null, [
							'class'            => 'form-control selectpick rq',
							'placeholder'      => '- Pilih Staf -',
							'id'               => 'antrianpoli_staf_id',
							'data-live-search' => 'true'
						])!!}
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group @if($errors->has('asuransi_id')) has-error @endif">
                      {!! Form::label('asuransi_id', 'Nama Asuransi', ['class' => 'control-label']) !!}
                      {!! Form::select('asuransi_id' , $asuransi_list, null, [
                        'class' => 'form-control rq',
                        'placeholder' => '- Pilih Asuransi -'
                      ]) !!}
                      @if($errors->has('asuransi_id'))<code>{!! $errors->first('asuransi_id') !!}</code>@endif
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group @if($errors->has('tanggal'))has-error @endif">
						  {!! Form::label('tanggal', 'Tanggal Konsultasi', ['class' => 'control-label']) !!}
						  {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control rq tanggal', 'id' => 'antrianpoli_tanggal']) !!}
						  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 hide" id="bukan_peserta">
					<div class="form-group @if($errors->has('bukan_peserta'))has-error @endif">
					  {!! Form::label('bukan_peserta', 'Peserta Klinik', ['class' => 'control-label']) !!}
					  {!! Form::select('bukan_peserta' , $peserta, '0', ['class' => 'form-control rq']) !!}
					  @if($errors->has('bukan_peserta'))<code>{{ $errors->first('bukan_peserta') }}</code>@endif
					</div>
				</div>	
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="cekProlanisHT">
					<div class="alert alert-danger">
						Prolanis HT
					</div>
				</div>
			</div>
			<div class="row hide" id="pengantar_pasien">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('pengantar_pasiens'))has-error @endif">
					  {!! Form::label('pengantar_pasiens', 'Pengantar Pasien', ['class' => 'control-label']) !!}
					  {!! Form::text('pengantar_pasiens' , null, ['class' => 'form-control']) !!}
					  @if($errors->has('pengantar_pasiens'))<code>{{ $errors->first('pengantar_pasiens') }}</code>@endif
					</div>
				</div>
			</div>
			<div class="row hide" id="peringatan_trimester_pertama_usg">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-danger">
						Jika Umur Kehamilan kurang dari 12 minggu, harus menahan kencing karena baru bisa diperiksa dalam keadaan ingin kencing
					</div>
				</div>
			</div>
			<div class="row hide" id="peringatan_usg_abdomen">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-danger">
						Pada Pasien dengan USG Abdomen harus menahan kencing karena baru bisa diperiksa dalam keadaan ingin kencing
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal-footer-left" id="modal-footer">
	<br />
<div class="row">
  <div class="text-left col-xs-8 col-sm-8 col-md-8 col-lg-8 red">
	 @include('peringatanbpjs', ['ns' => false])
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	  <div class="row">
	  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	  		@if(isset($update))
	  			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
	  		@else
	  			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
	  		@endif
	  		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	  	</div>
	  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
	  	</div>
	  </div>
  </div>
</div>
</div>
{!! Form::close() !!}
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
