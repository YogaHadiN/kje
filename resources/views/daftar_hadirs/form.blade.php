<div class="row hide">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('pasien_id')) has-error @endif">
		  {!! Form::label('pasien_id', 'Pasien id', ['class' => 'control-label']) !!}
		@if(isset($daftar))
			{!! Form::text('pasien_id' , $daftar->pasien->id, ['class' => 'form-control rq']) !!}
		@else
		  {!! Form::text('pasien_id' , $pasien->id, ['class' => 'form-control rq']) !!}
		@endif
		  @if($errors->has('pasien_id'))<code>{{ $errors->first('pasien_id') }}</code>@endif
		</div>
	</div>
</div>
<div class="row hide">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('waktu')) has-error @endif">
		  {!! Form::label('waktu', 'Waktu', ['class' => 'control-label']) !!}
		  {!! Form::text('waktu' , date('Y-m-d H:i:s'), ['class' => 'form-control rq']) !!}
		  @if($errors->has('waktu'))<code>{{ $errors->first('waktu') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
		  {!! Form::label('asuransi_id', 'Pembayaran', ['class' => 'control-label']) !!}
			{!! Form::select('asuransi_id', $asuransi_list, null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('poli_id')) has-error @endif">
		  {!! Form::label('poli_id', 'Poli', ['class' => 'control-label']) !!}
		  {!! Form::select('poli_id', $poli , null, ['class' => 'form-control rq']) !!}
		  @if($errors->has('poli_id'))<code>{{ $errors->first('poli_id') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('staf_id'))has-error @endif">
		  {!! Form::label('staf_id', 'Pemeriksa', ['class' => 'control-label']) !!}
			{!! Form::select('staf_id', $staf, null, array(
				'class'         => 'form-control rq selectpick',
				'data-live-search'         => 'true'
			))!!}
		  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		@if(isset($daftar))
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block" href="{{ url('home/daftars') }}">Cancel</a>
			</div>
		@else
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block" href="{{ url('home/pasiens') }}">Cancel</a>
			</div>
		@endif
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
</div>
