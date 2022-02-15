 <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
	 <div class="panel panel-default">
	 	<div class="panel-body">
			<div class="form-group @if($errors->has('nama'))has-error @endif">
			  {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
				{!! Form::text('nama', null, array(
					'class'         => 'form-control',
					'placeholder'   => 'nama',
					'id' => 'nama_supplier'
				))!!}
			  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('alamat'))has-error @endif">
			  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
				{!! Form::textarea('alamat', null, array(
					'class'         => 'form-control textareacustom',
					'placeholder'   => 'alamat'
				))!!}
			  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('no_telp'))has-error @endif">
			  {!! Form::label('no_telp', 'No Telp', ['class' => 'control-label']) !!}
				{!! Form::text('no_telp', null, array(
					'class'         => 'form-control',
					'placeholder'   => 'Nomor Telepon'
				))!!}
			  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('hp_pic'))has-error @endif">
			  {!! Form::label('hp_pic', 'Hp PIC', ['class' => 'control-label']) !!}
				{!! Form::text('hp_pic', null, array(
					'class'         => 'form-control',
					'placeholder'   => 'Nomor HP PIC'
				))!!}
			  @if($errors->has('hp_pic'))<code>{{ $errors->first('hp_pic') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('pic'))has-error @endif">
			  {!! Form::label('pic', 'PIC', ['class' => 'control-label']) !!}
				{!! Form::text('pic', null, array(
					'class'         => 'form-control',
					'placeholder'   => 'Person In Charge'
				))!!}
			  @if($errors->has('pic'))<code>{{ $errors->first('pic') }}</code>@endif
			</div>
			<div class="form-group" id="supplier_submit">
				<button class="btn btn-primary block full-width m-b" type="button" id="dummySubmitSupplier">{{ $submit }}</button>	
				{!! Form::submit($submit, array(
					'class' => 'hide btn btn-primary block full-width m-b'
				)) !!}
			</div>
	 	</div>
	 </div>
 </div>
<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
	<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
		{!! Form::label('image', 'KTP Image') !!}
		{!! Form::file('image') !!}
			@if (isset($supplier) && $supplier->image)
				<p> <img src="{{ \Storage::disk('s3')->url($supplier->image) }}" alt="" class="img-rounded upload"> </p>
			@else
				<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
			@endif
		{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
	</div>
	<div class="form-group{{ $errors->has('muka_image') ? ' has-error' : '' }}">
		{!! Form::label('muka_image', 'Foto Wajah') !!}
		{!! Form::file('muka_image') !!}
			@if (isset($supplier) && $supplier->muka_image)
				<p> <img src="{{ \Storage::disk('s3')->url($supplier->muka_image) }}" alt="" class="img-rounded upload"> </p>
			@else
				<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
			@endif
		{!! $errors->first('muka_image', '<p class="help-block">:message</p>') !!}
	</div>
</div>
