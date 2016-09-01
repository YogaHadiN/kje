<div class="row">
	 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						{!! Form::label('nama')!!}
						{!! Form::text('nama', $pasien->nama, array(
							'class'         => 'form-control',
							'placeholder'   => 'nama'
						))!!}
						<code>{!! $errors->first('nama')!!}</code>
					</div>
					<div class="form-group">
						{!! Form::label('alamat')!!}
						{!! Form::textarea('alamat', $pasien->alamat, array(
							'class'         => 'form-control textareacustom',
							'placeholder'   => 'alamat'
						))!!}
						<code>{!! $errors->first('alamat')!!}</code>
					</div>
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								{!! Form::label('tanggal_lahir')!!}
								{!! Form::input('date','tanggal_lahir', App\Classes\Yoga::updateDatePrep($pasien->tanggal_lahir), array(
									'class'         => 'form-control tanggal',
									'placeholder'   => 'Tanggal Lahir'
								))!!}
								<code>{!! $errors->first('tanggal_lahir')!!}</code>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								{!! Form::label('sex','Jenis Kelamin')!!}
								{!! Form::select('sex', array(
									null        => '- Jenis Kelamin -',
									'L'         => 'laki-laki',
									'P'         => 'perempuan',
								), null, array('class' => 'form-control'))!!}
								<code>{!! $errors->first('no_telp')!!}</code>
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								{!! Form::label('no_telp')!!}
								{!! Form::text('no_telp', $pasien->no_telp, array(
									'class'         => 'form-control',
									'placeholder'   => 'no_telp'
								))!!}
								<code>{!! $errors->first('no_telp')!!}</code>
							</div>
						</div>
					</div>  
					@if(!$facebook)
					<div class="row"  >
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('nama_ayah')!!}
								{!! Form::text('nama_ayah', $pasien->nama_ayah, array(
									'class'         => 'form-control',
									'placeholder'   => 'nama ayah'
								))!!}
								<code>{!! $errors->first('nama_ayah')!!}</code>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('nama_ibu')!!}
								{!! Form::text('nama_ibu', $pasien->nama_ibu, array(
									'class'         => 'form-control',
									'placeholder'   => 'nama ibu'
								))!!}
								<code>{!! $errors->first('nama_ibu')!!}</code>
							</div>
						</div>
					</div>  
					@endif
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('asuransi_id', 'Asuransi')!!}
								{!! Form::select('asuransi_id', $asuransi, $pasien->asuransi_id, array(
									'class'         => 'form-control selectpick', 
									'data-live-search'         => 'true'
								))!!}
								<code>{!! $errors->first('asuransi_id')!!}</code>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('nama_peserta')!!}
								{!! Form::text('nama_peserta', $pasien->nama_peserta, array(
									'class'         => 'form-control',
									'placeholder'   => 'nama_peserta'
								))!!}
								<code>{!! $errors->first('nama_peserta')!!}</code>
							</div>
						</div>
					</div>  
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('nomor_asuransi')!!}
								{!! Form::text('nomor_asuransi', $pasien->nomor_asuransi, array(
									'class'         => 'form-control',
									'placeholder'   => 'nomor asuransi'
								))!!}
								<code>{!! $errors->first('nomor_asuransi')!!}</code>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								{!! Form::label('jenis_peserta')!!}
								{!! Form::select('jenis_peserta', array(
								   null => '- Pilih Peserta -',
									'P' => 'Peserta',
									'S' => 'Suami',
									'I' => 'Istri',
									'A' => 'Anak'
									), $pasien->jenis_peserta, array(
									'class'         => 'form-control'
								))!!}
								<code>{!! $errors->first('jenis_peserta')!!}</code>
							</div>
						</div>
					</div>
					@if($facebook)
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group" @if($errors->has('email')) class="has-error" @endif>
							  {!! Form::label('email', 'Email') !!}
							  {!! Form::text('email' , null, [
								  'class' => 'form-control',
								  'readonly' => 'readonly'
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
					</div>
			 	</div>
			 </div>
			 <div class="row">
			 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
						{!! Form::label('bpjs_image', 'Foto Kartu BPJS') !!}
						{!! Form::file('bpjs_image') !!}
						@if (isset($pasien) && $pasien->bpjs_image)
							<p> {!! HTML::image(asset('img/pasien/'.$pasien->bpjs_image), null, ['class'=>'img-rounded upload']) !!} </p>
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
						<p> {!! HTML::image(asset('img/pasien/'.$pasien->ktp_image), null, ['class'=>'img-rounded upload']) !!} </p>
						@else
						<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						@endif
						{!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
					</div>
			 	</div>
			 </div>
		 </div>
	
</div>

