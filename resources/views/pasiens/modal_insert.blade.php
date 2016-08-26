<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	{!! Form::open(['url' => 'pasiens/ajax/create', 'id' => 'pasienInsertForm', 'method' => 'post', 'autocomplete' => 'off'])!!}
		<div class="row">
			<div class="col-lg-12 col-md-12">
				 <div class="form-group">
					{!! Form::label('nama', 'Nama Pasien')!!}
					{!! Form::text('nama', null, ['class' => 'form-control hh required 
						@if($rq)
							rq
						@endif
					', 'placeholder' => 'Masukkan nama tanpa gelar, tanpa nama panggilan'])!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					{!! Form::label('sex', 'Jenis Kelamin')!!}
					{!! Form::select('sex',[null => '- jenis kelamin -' , 'L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control required 
						@if($rq)
							rq
						@endif
					'])!!}
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group">

					{!! Form::label('tanggal_lahir', 'Tanggal Lahir')!!}
					{!! Form::text('tanggal_lahir', null, ['class' => 'form-control tanggal'])!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					{!! Form::label('nama_ibu', 'Nama Ibu')!!}
					{!! Form::text('nama_ibu',null, ['class' => 'form-control hh'])!!}
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group">
					{!! Form::label('nama_ayah', 'Nama Ayah')!!}
					{!! Form::text('nama_ayah', null, ['class' => 'form-control hh'])!!}
				</div>
			</div>
		</div>
		 <div class="row">
			<div class="col-lg-4 col-md-4">
				<div class="form-group">
					{!! Form::label('no_telp', 'Nomor Telepon')!!}
					{!! Form::text('no_telp', null, ['class' => 'form-control hh'])!!}
				</div>
			</div>
			<div class="col-lg-4 col-md-4">
				<div class="form-group">
					{!! Form::label('panggilan', 'Panggilan')!!}
					{!! Form::select('panggilan', $panggilan, null, ['class' => 'form-control hh required 
						@if($rq)
							rq
						@endif
					'])!!}
				</div>
			</div>
			<div class="col-lg-4 col-md-4">
				<div class="form-group">
					{!! Form::label('punya_asuransi', 'Punya Asuransi')!!} <br>
					{!! Form::checkbox('punya_asuransi', 0, false, ['id' => 'CheckBox1'])!!}
				</div>
			</div>
		</div>
		 <div class="displayNone transition" id="xx">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-xs-3 col-sm-63">
					<div class="form-group">
					  {!!Form::label('asuransi_id', 'Asuransi')!!}
					  {!!Form::select('asuransi_id', $asuransi, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true'])!!}
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
					<div class="form-group">
						{!! Form::label('jenis_peserta', 'Jenis Peserta')!!}

						{!! Form::select('jenis_peserta', $jenis_peserta, null, ['class' => 'form-control tog hh'])!!}
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
					<div class="form-group">
						{!! Form::label('nomor_asuransi', 'Nomor Asuransi')!!}
						{!! Form::text('nomor_asuransi', null, ['class' => 'form-control tog hh'])!!}
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
					<div class="form-group">
						{!! Form::label('nama_peserta', 'Nama Peserta')!!}
						{!! Form::text('nama_peserta', null, ['class'=>'form-control tog hh'])!!}
					</div>
				</div>
			</div>
		  </div>
		  <div class="row">
			  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
					{!! Form::label('alamat', null)!!}
					{!! Form::textarea('alamat', null, ['class' => 'form-control textareacustom'])!!}
				</div>
			  </div>
		  </div>
		  <div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  		<div class="form-group" @if($errors->has('email')) class="has-error" @endif>
		  		  {!! Form::label('email', 'Email') !!}
		  		  {!! Form::text('email' , null, [
					  'class' => 'form-control',
					  'readonly' => 'readonly',

				  ]) !!}
		  		  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
		  		</div>
		  	</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group" @if($errors->has('facebook_id')) class="has-error" @endif>
				  {!! Form::label('facebook_id', 'Facebook Id') !!}
				  {!! Form::text('facebook_id' , null, [
					  'class' => 'form-control',
					  'readonly' => 'readonly'
				  ]) !!}
				  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
				</div>
			</div>
		  </div>
		  <div class="row">
			  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  @include('antrianpolis.webcamForm', [
				  'image' => null,
				  'ktp_image' => null,
				  'subject'   => 'Pasien'
				  ])
			  </div>
		  </div>
	  </div>
  </div>
