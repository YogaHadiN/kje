<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	{!! Form::open(['url' => 'pasiens/ajax/create', 'id' => 'pasienInsertForm', 'method' => 'post', 'autocomplete' => 'off'])!!}
			  <h2>
				  @if( isset($pasien) )
					  Edit Pasien
				  @else
					Pasien Baru			  	
				  @endif
			  </h2>
			  <hr />
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="form-group @if($errors->has('nama'))has-error @endif">
				  {!! Form::label('nama', 'Nama Pasien', ['class' => 'control-label']) !!}
				  {!! Form::text('nama', !isset($pasien) && isset($antrian->nama)? $antrian->nama : null , ['class' => 'form-control hh required 
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
					{!! Form::select('sex',[
							null => '- jenis kelamin -' ,
							'1'  => 'Laki-laki',
							'0'  => 'Perempuan'
						], null, ['class' => 'form-control required 
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
				  @if (isset($pasien) && !empty( $pasien->tanggal_lahir ))
					  {!! Form::text('tanggal_lahir', $pasien->tanggal_lahir->format('d-m-Y'), ['class' => 'form-control tanggal', 'id' => 'tanggal_lahir'])!!}
				  @else
					  {!! Form::text('tanggal_lahir', 
						  !isset($pasien) && isset( $antrian->tanggal_lahir ) ? $antrian->tanggal_lahir->format('d-m-Y') : null, 
						  ['class' => 'form-control tanggal', 'id' => 'tanggal_lahir'])
					  !!}
				  @endif
				  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row" id="row_ajax_container" style="display:none">
			<div class="alert alert-danger">
				Berikut ini pasien dengan tanggal lahir yang sama, Jangan lanjutkan bila pasien sudah terdaftar
				 <a href="{{ url('pasiens/gabungkan/pasien/ganda') }}" target="_blank">Gabungkan</a> jika menemukan pasien  yagng dobel, tabel dengan latar warna merah adalah kemungkinan pasien duplikasi, gabungkan sebelum melanjutkan 
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Nama</th>
								<th>Alamat</th>
								<th>No Telp</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="ajax_container"></tbody>
					</table>
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
					{!! Form::text('no_telp', null, ['class' => 'form-control hh phone'])!!}
				  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
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
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
				<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
					{!! Form::label('asuransi_id', 'Asuransi', ['class' => 'control-label']) !!}
					{!!Form::select('asuransi_id', $asuransi, null, [
						'class'            => 'form-control selectpick',
						'id'               => 'asuransi_id',
						'placeholder'      => 'Biaya Pribadi',
						'data-live-search' => 'true'
					])!!}
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
					{!! Form::text('nomor_asuransi', !isset($pasien) && isset($antrian->nomor_asuransi)? $antrian->nomor_asuransi : null , [
						'id'      => 'nomor_asuransi',
						'class'   => 'form-control tog hh',
						'onkeyup' => 'cekNomorBpjsSama(this);return false;'
					])!!}
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
				  {!! Form::select('jangan_disms' , App\Models\Classes\Yoga::pasienSurvey(), null, ['class' => 'form-control']) !!}
				  @if($errors->has('jangan_disms'))<code>{{ $errors->first('jangan_disms') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('penangguhan_pembayaran_bjps'))has-error @endif">
				  {!! Form::label('penangguhan_pembayaran_bjps', 'Penangguhan Pembayaran BPJS', ['class' => 'control-label']) !!}
				  {!! Form::select('penangguhan_pembayaran_bjps', [
					  '0' => 'Tidak',
					  '1' => 'Ya'
					  ], null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('penangguhan_pembayaran_bjps'))<code>{{ $errors->first('penangguhan_pembayaran_bjps') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('meninggal'))has-error @endif">
				  {!! Form::label('meninggal', 'Meninggal HT', ['class' => 'control-label']) !!}
				  {!! Form::select('meninggal', [
					  '0' => 'Tidak',
					  '1' => 'Ya'
					  ], null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('meninggal'))<code>{{ $errors->first('meninggal') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('verifikasi_prolanis_dm_id'))has-error @endif">
				  {!! Form::label('verifikasi_prolanis_dm_id', 'Verifikasi Prolanis DM', ['class' => 'control-label']) !!}
				  {!! Form::select('verifikasi_prolanis_dm_id', $verifikasi_prolanis_options, null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('verifikasi_prolanis_dm_id'))<code>{{ $errors->first('verifikasi_prolanis_dm_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('verifikasi_prolanis_ht_id'))has-error @endif">
				  {!! Form::label('verifikasi_prolanis_ht_id', 'Verifikasi Prolanis HT', ['class' => 'control-label']) !!}
				  {!! Form::select('verifikasi_prolanis_ht_id', $verifikasi_prolanis_options, null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('verifikasi_prolanis_ht_id'))<code>{{ $errors->first('verifikasi_prolanis_ht_id') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('prolanis_dm'))has-error @endif">
				  {!! Form::label('prolanis_dm', 'Prolanis DM', ['class' => 'control-label']) !!}
				  {!! Form::select('prolanis_dm', [
					  '0' => 'Tidak Terdaftar',
					  '1' => 'Terdaftar'
					  ], null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('prolanis_dm'))<code>{{ $errors->first('prolanis_dm') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('prolanis_ht'))has-error @endif">
				  {!! Form::label('prolanis_ht', 'Prolanis HT', ['class' => 'control-label']) !!}
				  {!! Form::select('prolanis_ht', [
					  '0' => 'Tidak Terdaftar',
					  '1' => 'Terdaftar'
					  ], null, array(
						'class'         => 'form-control'
					))!!}
				  @if($errors->has('prolanis_ht'))<code>{{ $errors->first('prolanis_ht') }}</code>@endif
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
										{{--<p> <img src="{{ asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) }}" alt=""> !!} </p>--}}
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
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Nama Dokter', ['class' => 'control-label']) !!}
				  {!! Form::select('staf_id' , App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq' , 'data-live-search' => 'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('poli'))has-error @endif">
				  {!! Form::label('poli', 'Poli', ['class' => 'control-label']) !!}
				  {!! Form::select('poli' , $poli, null, [
					  'class'    => 'form-control rq',
					  'onchange' => 'pilihPoli(this);return false;'
				  ]) !!}
				  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
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
