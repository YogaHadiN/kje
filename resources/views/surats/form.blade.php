<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('tanggal'))has-error @endif">
		  {!! Form::label('tanggal', 'Tanggal Diterima / Dikirim', ['class' => 'control-label']) !!}
		  @if(isset($surat))
			  {!! Form::text('tanggal',  $surat->tanggal->format('d-m-Y'), array(
				'class'         => 'form-control tanggal rq'
			))!!}
		  @else
			{!! Form::text('tanggal',  null, array(
				'class'         => 'form-control tanggal rq'
			))!!}
		  @endif
		  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('surat_masuk'))has-error @endif">
		  {!! Form::label('surat_masuk', 'Jenis Surat', ['class' => 'control-label']) !!}
		  {!! Form::select('surat_masuk', [
				  null => '- Jenis Surat -',
				  0    => 'Surat Keluar',
				  1    => 'Surat Masuk'
			  ], null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('surat_masuk'))<code>{{ $errors->first('surat_masuk') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('nomor_surat'))has-error @endif">
		  {!! Form::label('nomor_surat', 'Nomor Surat', ['class' => 'control-label']) !!}
			{!! Form::text('nomor_surat', null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('nomor_surat'))<code>{{ $errors->first('nomor_surat') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('alamat'))has-error @endif">
		  {!! Form::label('alamat', 'Alamat Kirim / Dari', ['class' => 'control-label']) !!}
			{!! Form::textarea('alamat',  null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group{{ $errors->has('foto_surat') ? ' has-error' : '' }}">
			{!! Form::label('foto_surat', 'Foto Surat') !!}
			{!! Form::file('foto_surat') !!}
				@if (isset($surat) && $surat->foto_surat)
					<p> <img src="{{ \Storage::disk('s3')->url('img/surat/'.$surat->foto_surat) }}" alt="" class="img-rounded upload"> </p>
				@else
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				@endif
			{!! $errors->first('foto_surat', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		@if(isset($surat))
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
		@else
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
		@endif
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
	</div>
</div>
