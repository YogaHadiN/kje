
<div class="form-group @if($errors->has('bulanTahun')) has-error @endif">
	{!! Form::label('bulanTahun', 'Bulan Tahun', ['class' => 'control-label']) !!}
	{!! Form::text('bulanTahun' , isset( $denominator_bpjs ) ? $denominator_bpjs->bulanTahun->format('m-Y') : date('m-Y'), ['class' => 'form-control bulanTahun']) !!}
	@if($errors->has('bulanTahun'))<code>{{ $errors->first('bulanTahun') }}</code>@endif
</div>
<div class="form-group @if($errors->has('jumlah_peserta')) has-error @endif">
	{!! Form::label('jumlah_peserta', 'Jumlah Peserta', ['class' => 'control-label']) !!}
	{!! Form::text('jumlah_peserta' , null, ['class' => 'form-control angka']) !!}
	@if($errors->has('jumlah_peserta'))<code>{{ $errors->first('jumlah_peserta') }}</code>@endif
</div>
<div class="form-group @if($errors->has('denominator_dm')) has-error @endif">
	{!! Form::label('denominator_dm', 'Denominator DM', ['class' => 'control-label']) !!}
	{!! Form::text('denominator_dm' , null, ['class' => 'form-control angka']) !!}
	@if($errors->has('denominator_dm'))<code>{{ $errors->first('denominator_dm') }}</code>@endif
</div>
<div class="form-group @if($errors->has('denominator_ht')) has-error @endif">
	{!! Form::label('denominator_ht', 'Denominator HT', ['class' => 'control-label']) !!}
	{!! Form::text('denominator_ht' , null, ['class' => 'form-control angka']) !!}
	@if($errors->has('denominator_ht'))<code>{{ $errors->first('denominator_ht') }}</code>@endif
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		@if(isset($denominator_bpjs))
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
		@else
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
		@endif
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block" href="{{ url('denominator_bpjs') }}">Cancel</a>
	</div>
</div>
