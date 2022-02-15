<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasiAsuransi">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title">Konfirmasi Asuransi, Asuransi <span class="nama_asuransi"></span> </h4>
	  </div>
	  <div class="modal-body">
		  <div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<img class="imgKonfirmasi img-rounded" src="" alt="" width="500px" height="375px" id="konfirmasi_pasien_image">
		  	</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('nama'))has-error @endif">
						  {!! Form::label('nama', 'Nama Pasien', ['class' => 'control-label']) !!}
						  {!! Form::text('nama' , null, ['class' => 'form-control', 'id' => 'konfirmasi_nama', 'readonly' => 'readonly'] ) !!}
						  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('alamat'))has-error @endif">
						  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
						  {!! Form::textarea('alamat' , null, ['class' => 'form-control textareacustom', 'id' => 'konfirmasi_alamat', 'readonly' => 'readonly']) !!}
						  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('tanggal_lahir'))has-error @endif">
						  {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
						  {!! Form::text('tanggal_lahir' , null, ['class' => 'form-control', 'id' => 'konfirmasi_tanggal_lahir', 'readonly' => 'readonly']) !!}
						  @if($errors->has('tanggal_lahir'))<code>{{ $errors->first('tanggal_lahir') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('nomor_asuransi'))has-error @endif">
						  {!! Form::label('nomor_asuransi', 'Nomor Asuransi', ['class' => 'control-label']) !!}
						  {!! Form::text('nomor_asuransi' , null, ['class' => 'form-control', 'id' => 'konfirmasi_nomor_asuransi', 'readonly', 'readonly']) !!}
						  @if($errors->has('nomor_asuransi'))<code>{{ $errors->first('nomor_asuransi') }}</code>@endif
						</div>
					</div>
				</div>
		  	</div>
		  </div>
			<div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<img class="imgKonfirmasi img-rounded" src="" alt="" width="500px" height="375px" id="konfirmasi_ktp_image">
		  	</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<img class="imgKonfirmasi img-rounded" src="" alt="" width="500px" height="375px" id="konfirmasi_bpjs_image">
		  	</div>
		  </div>
	  </div>
	  <div class="modal-footer text-right">
			{!! Form::open(['url' => 'fasilitas/konfirmasi', 'method' => 'put', 'class' => 'text-right']) !!}
			{!! Form::text('konfirmasi_antrian_poli_id', null, ['class' => 'hide', 'id' => 'konfirmasi_antrian_poli_id']) !!}
				<button class="btn btn-success btn-lg" type="submit" onclick="return confirm('Apa Anda yakin Asuransi untuk pasien ini sudah bisa digunakan? Karena Pasien mendaftar menggunakan fasilitas daftar sendiri')">Konfirmasi</button>
				<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" aria-label="Close">Cancel</button>
			{!! Form::close() !!}
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

