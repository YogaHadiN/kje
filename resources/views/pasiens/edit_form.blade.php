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
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
				  {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
					{!! Form::input('date','tanggal_lahir', App\Classes\Yoga::updateDatePrep($pasien->tanggal_lahir), array(
						'class'         => 'form-control tanggal',
						'placeholder'   => 'Tanggal Lahir'
					))!!}
				  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('sex'))has-error @endif">
				  {!! Form::label('sex', 'Jenis Kelamin', ['class' => 'control-label']) !!}
					{!! Form::select('sex', array(
						null        => '- Jenis Kelamin -',
						'L'         => 'laki-laki',
						'P'         => 'perempuan',
					), null, array('class' => 'form-control'))!!}
				  @if($errors->has('sex'))<code>{{ $errors->first('sex') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
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
					@if(!$facebook)
					<div class="row"  >
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('nama_ayah'))has-error @endif">
							  {!! Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) !!}
								{!! Form::text('nama_ayah', $pasien->nama_ayah, array(
									'class'         => 'form-control',
									'placeholder'   => 'nama ayah'
								))!!}
							  @if($errors->has('nama_ayah'))<code>{{ $errors->first('nama_ayah') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('nama_ibu'))has-error @endif">
							  {!! Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) !!}
								{!! Form::text('nama_ibu', $pasien->nama_ibu, array(
									'class'         => 'form-control',
									'placeholder'   => 'nama ibu'
								))!!}
							  @if($errors->has('nama_ibu'))<code>{{ $errors->first('nama_ibu') }}</code>@endif
							</div>
						</div>
					</div>  
					@endif
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
							  {!! Form::label('asuransi_id', 'Asuransi', ['class' => 'control-label']) !!}
								{!! Form::select('asuransi_id', $asuransi, $pasien->asuransi_id, array(
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
					@if($facebook)
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

							<div class="form-group @if($errors->has('email'))has-error @endif">
							  {!! Form::label('email', 'Email') !!}
							  {!! Form::text('email' , null, [
								  'class' => 'form-control',
								  'readonly' => 'readonly'
							  ]) !!}
							  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

							<div class="form-group @if($errors->has('facebook_id'))has-error @endif">
							  {!! Form::label('facebook_id', 'Facebook Id') !!}
							  {!! Form::text('facebook_id' , null, [
								  'class' => 'form-control',
								  'readonly' => 'readonly'
							  ]) !!}
							  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
							</div>
						</div>
					</div>
				@endif
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
						@include('antrianpolis.webcamForm', [
							'image' => $pasien->image, 
							'ktp_image'=> $pasien->ktp_image,
							'subject'   => 'Pasien'
						])    
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
					<div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
						{!! Form::label('bpjs_image', 'Foto Kartu BPJS') !!}
						{!! Form::file('bpjs_image') !!}
						@if (isset($pasien) && $pasien->bpjs_image)
							<p> {!! HTML::image(asset($pasien->bpjs_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
							<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
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
						<p> {!! HTML::image(asset($pasien->ktp_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
						<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						@endif
						{!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
					</div>
			 	</div>
			 </div>
		 </div>
</div>

