<div class="row">
	 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('nama'))has-error @endif">
		  {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
			{!! Form::text('nama', $pasien->nama, array(
				'class'         => 'form-control',
				'placeholder'   => 'nama'
			))!!}
		  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
		</div>
		<div class="form-group @if($errors->has('alamat'))has-error @endif">
		  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
			{!! Form::textarea('alamat', $pasien->alamat, array(
				'class'         => 'form-control textareacustom',
				'placeholder'   => 'alamat'
			))!!}
		  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
				  {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
					{!! Form::text('tanggal_lahir', App\Models\Classes\Yoga::updateDatePrep($pasien->tanggal_lahir), array(
						'class'         => 'form-control tanggal',
						'placeholder'   => 'Tanggal Lahir'
					))!!}
				  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('sex'))has-error @endif">
				  {!! Form::label('sex', 'Jenis Kelamin', ['class' => 'control-label']) !!}
					{!! Form::select('sex', array(
						null        => '- Jenis Kelamin -',
						'1'         => 'laki-laki',
						'0'         => 'perempuan',
					), null, array('class' => 'form-control'))!!}
				  @if($errors->has('sex'))<code>{{ $errors->first('sex') }}</code>@endif
				</div>
			</div>
		</div>  
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('nomor_ktp'))has-error @endif">
				  {!! Form::label('nomor_ktp', 'Nomor KTP', ['class' => 'control-label']) !!}
				  {!! Form::text('nomor_ktp' , null, ['class' => 'form-control']) !!}
				  @if($errors->has('nomor_ktp'))<code>{{ $errors->first('nomor_ktp') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('no_telp'))has-error @endif">
				  {!! Form::label('no_telp', 'No Telp', ['class' => 'control-label']) !!}
					{!! Form::text('no_telp', $pasien->no_telp, array(
						'class'         => 'form-control',
						'placeholder'   => 'no_telp'
					))!!}
				  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
				  {!! Form::label('asuransi_id', 'Asuransi', ['class' => 'control-label']) !!}
					{!! Form::select('asuransi_id', $asuransi, $pasien->asuransi_id, array(
						'id'         => 'asuransi_id', 
						'class'         => 'form-control selectpick', 
						'data-live-search'         => 'true'
					))!!}
				  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('nama_peserta'))has-error @endif">
				  {!! Form::label('nama_peserta', 'Nama Peserta', ['class' => 'control-label']) !!}
					{!! Form::text('nama_peserta', $pasien->nama_peserta, array(
						'class'         => 'form-control',
						'placeholder'   => 'nama_peserta'
					))!!}
				  @if($errors->has('nama_peserta'))<code>{{ $errors->first('nama_peserta') }}</code>@endif
				</div>
			</div>
		</div>  
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('nomor_asuransi'))has-error @endif">
				  {!! Form::label('nomor_asuransi', 'Nomor Asuransi', ['class' => 'control-label']) !!}
					{!! Form::text('nomor_asuransi', $pasien->nomor_asuransi, array(
						'id'         => 'nomor_asuransi',
						'class'         => 'form-control',
						'placeholder'   => 'nomor asuransi'
					))!!}
				  @if($errors->has('nomor_asuransi'))<code>{{ $errors->first('nomor_asuransi') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('jenis_peserta'))has-error @endif">
				  {!! Form::label('jenis_peserta', 'Jenis Peserta', ['class' => 'control-label']) !!}
					{!! Form::select('jenis_peserta', array(
					   null => '- Pilih Peserta -',
						'P' => 'Peserta',
						'S' => 'Suami',
						'I' => 'Istri',
						'A' => 'Anak'
						), $pasien->jenis_peserta, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('jenis_peserta'))<code>{{ $errors->first('jenis_peserta') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('nomor_asuransi_bpjs'))has-error @endif">
				  {!! Form::label('nomor_asuransi_bpjs', 'Nomor BPJS', ['class' => 'control-label']) !!}
				  {!! Form::text('nomor_asuransi_bpjs' , null, ['class' => 'form-control']) !!}
				  @if($errors->has('nomor_asuransi_bpjs'))<code>{{ $errors->first('nomor_asuransi_bpjs') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('jangan_disms'))has-error @endif">
				  {!! Form::label('jangan_disms', 'Status Survey SMS', ['class' => 'control-label']) !!}
				  {!! Form::select('jangan_disms' , $pasienSurvey, 0, ['class' => 'form-control']) !!}
				  @if($errors->has('jangan_disms'))<code>{{ $errors->first('jangan_disms') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
					<button class="btn btn-primary block full-width m-b" type="button" onclick="dummySubmit();return false">SUBMIT</button>
				{!! Form::submit('SUBMIT', array(
					'class' => 'hide btn btn-primary block full-width m-b',
					'id' => 'submit'
				))!!}
				</div>
			</div>
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
			   <a href="{!!URL::to('pasiens')!!}" class="btn btn-warning block" > Cancel </a>
				</div>
			</div>
		</div>
	 </div>
	 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		 <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div>
					<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
						{!! Form::label('image', 'Foto Wajah Pasien') !!}
						{!! Form::file('image') !!}
							@if (isset($pasien) && $pasien->image)
								<p> <img src="{{ \Storage::disk('s3')->url($pasien->image) }}" alt="" class="img-rounded upload"> </p>
							@else
								<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							@endif
						{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
					</div>
				</div>
				<div>
					@if (Session::has('cek'))
					  <div class="alert alert-danger">
						  <button type="button" class="close" data-dismiss="alert" aria-label="ClosANTe"><span aria-hidden="true">&times;</span></button>
						<h2 class="text-center">PASIEN PESERTA BPJS TIDAK BISA DIPROSES UNTUK BEROBAT KARENA GAMBAR BELUM TERSEDIA</h2>
						  <ul>
							  <li>Gambar <strong>Foto pasien (bila anak2) atau gambar KTP pasien (bila DEWASA) </strong> harus dimasukkan terlebih dahulu</li>
							  <li>Klik lambang kamera di pojok kiri atas sebelah alamat website untuk menyalakan kamera</li>
							  <li>Klik 'Bagikan Perangkat Terpilih'</li>
							  <li>Klik Edit Foto</li>
							  <li>Klik tombol Ambil Gambar untuk menangkap gambar</li>
							  <li>Klik Submit untuk Update data pasien</li>
						  </ul> 
					  </div>
					@endif
					@if( Session::has('back'))
						<input class="form-control" type="text" name="back" id="back" value="{{ Session::get('back') }}" />
					@endif
				</div>
			</div>
		 </div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('kartu_asuransi_image') ? ' has-error' : '' }}">
					{!! Form::label('kartu_asuransi_image', 'Foto Kartu Asuransi') !!}
					{!! Form::file('kartu_asuransi_image') !!}
					@if (isset($pasien) && $pasien->kartu_asuransi_image)
						<p> <img src="{{ \Storage::disk('s3')->url($pasien->kartu_asuransi_image) }}" alt="" class="img-rounded upload"> </p>
					@else
						<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
					@endif
					{!! $errors->first('kartu_asuransi_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		 </div>
		 <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
					{!! Form::label('bpjs_image', 'Foto Kartu BPJS') !!}
					{!! Form::file('bpjs_image') !!}
					@if (isset($pasien) && $pasien->bpjs_image)
						<p> <img src="{{ \Storage::disk('s3')->url($pasien->bpjs_image) }}" alt="" class="img-rounded upload"> </p>
					@else
						<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
					@endif
					{!! $errors->first('bpjs_image', '<p class="help-block">:message</p>') !!}

				</div>
			</div>
		 </div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
					{!! Form::label('ktp_image', 'Foto KTP') !!}
					{!! Form::file('ktp_image') !!}
					@if (isset($pasien) && $pasien->ktp_image)
						<p> <img src="{{ \Storage::disk('s3')->url($pasien->ktp_image) }}" alt="" class="img-rounded upload"> </p>
					@else
						<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
					@endif
					{!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
				</div>
			</div>
		 </div>
	 </div>
</div>
