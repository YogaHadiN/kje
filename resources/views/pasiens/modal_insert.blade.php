<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	{!! Form::open(['url' => 'pasiens/ajax/create', 'id' => 'pasienInsertForm', 'method' => 'post', 'autocomplete' => 'off'])!!}
			  <h2>Pasien Baru</h2>
			  <hr />
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="form-group @if($errors->has('nama'))has-error @endif">
				  {!! Form::label('nama', 'Nama Pasien', ['class' => 'control-label']) !!}
					{!! Form::text('nama', null, ['class' => 'form-control hh required 
						@if($rq)
							rq
						@endif
						', 'placeholder' => 'Masukkan nama tanpa gelar, tanpa nama panggilan'])
					!!}
				  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group @if($errors->has('sex'))has-error @endif">
				  {!! Form::label('sex', 'Jenis Kelamin', ['class' => 'control-label']) !!}
				{!! Form::select('sex',[null => '- jenis kelamin -' , 'L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control required 
					@if($rq)
						rq
					@endif
				'])!!}
				  @if($errors->has('sex'))<code>{{ $errors->first('sex') }}</code>@endif
				</div>
			</div>
			<div class="col-lg-6 col-md-6">

				<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
				  {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
					{!! Form::text('tanggal_lahir', null, ['class' => 'form-control tanggal'])!!}
				  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group @if($errors->has('nama_ibu'))has-error @endif">
				  {!! Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) !!}
					{!! Form::text('nama_ibu',null, ['class' => 'form-control hh'])!!}
				  @if($errors->has('nama_ibu'))<code>{{ $errors->first('nama_ibu') }}</code>@endif
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group @if($errors->has('nama_ayah'))has-error @endif">
				  {!! Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) !!}
					{!! Form::text('nama_ayah', null, ['class' => 'form-control hh'])!!}
				  @if($errors->has('nama_ayah'))<code>{{ $errors->first('nama_ayah') }}</code>@endif
				</div>
			</div>
		</div>
		 <div class="row">
			<div class="col-lg-6 col-md-6">

				<div class="form-group @if($errors->has('no_telp'))has-error @endif">
				  {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
					{!! Form::text('no_telp', null, ['class' => 'form-control hh'])!!}
				  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
				</div>
			</div>
			<div class="col-lg-6 col-md-6">


				<div class="form-group @if($errors->has('panggilan'))has-error @endif">
				  {!! Form::label('panggilan', 'Panggilan', ['class' => 'control-label']) !!}
					{!! Form::select('panggilan', $panggilan, null, ['class' => 'form-control hh required 
						@if($rq)
							rq
						@endif
					'])!!}
				  @if($errors->has('panggilan'))<code>{{ $errors->first('panggilan') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('no_ktp'))has-error @endif">
				  {!! Form::label('no_ktp', 'Nomor KTP', ['class' => 'control-label']) !!}
				  {!! Form::text('no_ktp' , null, ['class' => 'form-control']) !!}
				  @if($errors->has('no_ktp'))<code>{{ $errors->first('no_ktp') }}</code>@endif
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="form-group @if($errors->has('punya_asuransi'))has-error @endif">
				  {!! Form::label('punya_asuransi', 'Punya Asuransi', ['class' => 'control-label']) !!}
					{!! Form::checkbox('punya_asuransi', 0, false, ['id' => 'CheckBox1'])!!}
				  @if($errors->has('punya_asuransi'))<code>{{ $errors->first('punya_asuransi') }}</code>@endif
				</div>
			</div>
		</div>
		 <div class="displayNone transition" id="xx">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
					<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
					  {!! Form::label('asuransi_id', 'Asuransi', ['class' => 'control-label']) !!}
					  {!!Form::select('asuransi_id', $asuransi, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true'])!!}
					  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
					<div class="form-group @if($errors->has('jenis_peserta'))has-error @endif">
					  {!! Form::label('jenis_peserta', 'Jenis Peserta', ['class' => 'control-label']) !!}
						{!! Form::select('jenis_peserta', $jenis_peserta, null, ['class' => 'form-control tog hh'])!!}
					  @if($errors->has('jenis_peserta'))<code>{{ $errors->first('jenis_peserta') }}</code>@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
					<div class="form-group @if($errors->has('nomor_asuransi'))has-error @endif">
					  {!! Form::label('nomor_asuransi', 'Nomor Asuransi', ['class' => 'control-label']) !!}
						{!! Form::text('nomor_asuransi', null, ['class' => 'form-control tog hh'])!!}
					  @if($errors->has('nomor_asuransi'))<code>{{ $errors->first('nomor_asuransi') }}</code>@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
					<div class="form-group @if($errors->has('nama_peserta'))has-error @endif">
					  {!! Form::label('nama_peserta', 'Nama Peserta', ['class' => 'control-label']) !!}
						{!! Form::text('nama_peserta', null, ['class'=>'form-control tog hh'])!!}
					  @if($errors->has('nama_peserta'))<code>{{ $errors->first('nama_peserta') }}</code>@endif
					</div>
				</div>
			</div>	
		  </div>
		  <div class="row">
			  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('alamat'))has-error @endif">
				    {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
					@if( isset($alamatPasien) )
						{!! Form::textarea('alamat', $alamatPasien, ['class' => 'form-control textareacustom'])!!}
					@else
						{!! Form::textarea('alamat', null, ['class' => 'form-control textareacustom'])!!}
					@endif
				    @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
				  </div>
			  </div>
		  </div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('jangan_disms'))has-error @endif">
				  {!! Form::label('jangan_disms', 'Status Survey SMS', ['class' => 'control-label']) !!}
				  {!! Form::select('jangan_disms' , App\Classes\Yoga::pasienSurvey(), 0, ['class' => 'form-control']) !!}
				  @if($errors->has('jangan_disms'))<code>{{ $errors->first('jangan_disms') }}</code>@endif
				</div>
			</div>
		</div>
		  
		{{--<div class="row">--}}
			{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
				{{--<div>--}}
				
				  {{--<!-- Nav tabs -->--}}
				  {{--<ul class="nav nav-tabs" role="tablist">--}}
					{{--<li role="presentation" class="active"><a href="#cari_kepala_keluarga" aria-controls="cari_kepala_keluarga" role="tab" data-toggle="tab">Cari Kepala Keluarga</a></li>--}}
					{{--<li role="presentation"><a href="#buat_kepala_keluarga" aria-controls="buat_kepala_keluarga" role="tab" data-toggle="tab">Buat Kepala Keluarga</a></li>--}}
				  {{--</ul>--}}
				  {{--<!-- Tab panes -->--}}
				  {{--<div class="tab-content">--}}
					{{--<div role="tabpanel" class="tab-pane active" id="cari_kepala_keluarga">--}}
						{{--<div class="form-group @if($errors->has('kepala_keluarga_id'))has-error @endif">--}}
						  {{--{!! Form::label('kepala_keluarga_id', 'Nama Kepala Keluarga', ['class' => 'control-label']) !!}--}}
						  {{--<p>format : nama(spasi)tanggal_lahir(spasi)alamat</p>--}}
 
						  {{--{!! Form::select('kepala_keluarga_id' , [], null, ['class' => 'form-control selectPasien']) !!}--}}
						  {{--@if($errors->has('kepala_keluarga_id'))<code>{{ $errors->first('kepala_keluarga_id') }}</code>@endif--}}
						{{--</div>--}}
					{{--</div>--}}
					{{--<div role="tabpanel" class="tab-pane" id="buat_kepala_keluarga">--}}
						{{--<div class="row">--}}
							{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
								{{--<div class="form-group @if($errors->has('kepala_keluarga_nama'))has-error @endif">--}}
								  {{--{!! Form::label('kepala_keluarga_nama', 'Nama Kepala Keluarga', ['class' => 'control-label']) !!}--}}
								  {{--{!! Form::text('kepala_keluarga_nama' , null, ['class' => 'form-control']) !!}--}}
								  {{--@if($errors->has('kepala_keluarga_nama'))<code>{{ $errors->first('kepala_keluarga_nama') }}</code>@endif--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>	--}}
						{{--<div class="row">--}}
							{{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">--}}
								{{--<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">--}}
								  {{--{!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}--}}
								  {{--{!! Form::text('tanggal_lahir' , null, ['class' => 'form-control tanggal']) !!}--}}
								  {{--@if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">--}}
								{{--<div class="form-group @if($errors->has('nomor asuransi'))has-error @endif">--}}
								  {{--{!! Form::label('kepala_keluarga_nomor_asuransi', 'Nomor Asuransi', ['class' => 'control-label']) !!}--}}
								  {{--{!! Form::text('kepala_keluarga_nomor_asuransi' , null, ['class' => 'form-control']) !!}--}}
								  {{--@if($errors->has('kepala_keluarga_nomor_asuransi'))<code>{{ $errors->first('nomor asuransi') }}</code>@endif--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div class="row">--}}
							{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
								{{--<div class="form-group{{ $errors->has('kepala_keluarga_kartu_bpjs') ? ' has-error' : '' }}">--}}
									{{--{!! Form::label('kepala_keluarga_kartu_bpjs', 'Kartu BPJS Kepala Keluarga') !!}--}}
									{{--{!! Form::file('kepala_keluarga_kartu_bpjs') !!}--}}
										{{--<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>--}}
									{{--{!! $errors->first('kepala_keluarga_kartu_bpjs', '<p class="help-block">:message</p>') !!}--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}
				  {{--</div>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
		  @if($facebook)
		  <div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

				<div class="form-group @if($errors->has('email'))has-error @endif">
		  		  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
		  		  {!! Form::text('email' , null, [
					  'class' => 'form-control',
					  'readonly' => 'readonly',

				  ]) !!}
		  		  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
		  		</div>
		  	</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

				<div class="form-group @if($errors->has('facebook_id'))has-error @endif">
				  {!! Form::label('facebook_id', 'Facebook Id', ['class' => 'control-label']) !!}
				  {!! Form::text('facebook_id' , null, [
					  'class' => 'form-control',
					  'readonly' => 'readonly'
				  ]) !!}
				  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
				</div>
			</div>
		  </div>
		  @endif
		@if(!isset( $pengantar ))	
		  @endif

		  @if(!$facebook)
			  <h2>Antrian Poli</h2>
			  <hr />
		 <div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Nama Dokter', ['class' => 'control-label']) !!}
				  {!! Form::select('staf_id' , App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick' , 'data-live-search' => 'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

				<div class="form-group @if($errors->has('poli'))has-error @endif">
				  {!! Form::label('poli', 'Poli', ['class' => 'control-label']) !!}
				  {!! Form::select('poli' , App\Classes\Yoga::poliList(), null, [
					  'class' => 'form-control',
					  'onchange' => 'pilihPoli(this);return false;'
				  ]) !!}
				  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

				<div class="form-group @if($errors->has('antrian'))has-error @endif">
				  {!! Form::label('antrian', 'Antrian') !!}
				  {!! Form::text('antrian' , null, ['class' => 'form-control angka']) !!}
				  @if($errors->has('antrian'))<code>{{ $errors->first('antrian') }}</code>@endif
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
		  @endif
	  </div>
  </div>
