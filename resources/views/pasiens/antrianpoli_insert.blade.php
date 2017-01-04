<form action="antrianpolis" method="post">
	<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
	<div class="row">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<img src="" alt="" width="220px" height="165px" id="imageForm" class="image" >
		</div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<div class="form-group">
						<label for="namaPasien" class="control-label">Nama Pasien</label>
						<label class="form-control" id="lblInputNamaPasien"></label>
						<input type="text" class="displayNone" name="nama" id="namaPasien"/>
						<input type="text" class="displayNone" name="pasien_id" id="ID_PASIEN"/>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<div class="form-group">
						<label for="nama" class="control-label">Antrian</label>
						<input type="text" class="form-control angka" name="antrian" id="antrianpoli_antrian" required/>
						<div id="validasiAntrian"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Poli:</label>
						{!! Form::select('poli', $poli, null, [
							'id' => 'antrianpoli_poli', 
							'class' => 'form-control', 
							'onchange' => 'pilihPoli(this);return false;'
						])!!}
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Dokter</label>
						{!! Form::select('staf_id', $staf, null, [
						'class' => 'form-control selectpick',
						'id' => 'antrianpoli_staf_id',
						'data-live-search' => 'true'
						])!!}
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Pembayarans</label>
							<select id="ddlPembayaran" class="form-control" name="asuransi_id" required>
								<option value="">- Pilih Pembayaran -</option>
								<option value="0">Biaya Pribadi</option>
							</select>
						<input type=text id="TextBox2" class="displayNone"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group @if($errors->has('tanggal'))has-error @endif">
						  {!! Form::label('tanggal', 'Tanggal Konsultasi', ['class' => 'control-label']) !!}
						  {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal', 'id' => 'antrianpoli_tanggal']) !!}
						  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 hide" id="bukan_peserta">
					<div class="form-group @if($errors->has('bukan_peserta'))has-error @endif">
					  {!! Form::label('bukan_peserta', 'Peserta Klinik', ['class' => 'control-label']) !!}
					  {!! Form::select('bukan_peserta' , $peserta, '0', ['class' => 'form-control']) !!}
					  @if($errors->has('bukan_peserta'))<code>{{ $errors->first('bukan_peserta') }}</code>@endif
					</div>
				</div>	
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="antrian_terakhir">

				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('no_ktp'))has-error @endif">
					  {!! Form::label('no_ktp', 'Nomor KTP', ['class' => 'control-label']) !!}
					  {!! Form::text('no_ktp' , null, [
						  'class'       => 'form-control',
						  'maxlength' => '16',
						  'placeholder' => 'Hanya diisi untuk Klaim Promo Ulang Tahun Kecantikan',
						  'onkeyup'     => 'cekPromo(this);return false;'
					  ]) !!}
					  @if($errors->has('no_ktp'))<code>{{ $errors->first('no_ktp') }}</code>@endif
					</div>
				</div>
			</div>
			<div class="row hide" id="pengantar_pasien">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('pengantar_pasiens'))has-error @endif">
					  {!! Form::label('pengantar_pasiens', 'Pengantar Pasien', ['class' => 'control-label']) !!}
					  {!! Form::text('pengantar_pasiens' , null, ['class' => 'form-control']) !!}
					  @if($errors->has('pengantar_pasiens'))<code>{{ $errors->first('pengantar_pasiens') }}</code>@endif
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
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button type="button" class="btn btn-danger btn-block" id="btnComplain" onclick='adaComplain(this);return false;'>Apakah Pasien Komplain?</button>
					<div class="panel panel-danger" id="timbul">
						  <div class="panel-heading">
								<h3 class="panel-title">Formulir Komplain</h3>
						  </div>
						  <div class="panel-body">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="">Pasien Komplain Atas Pelayanan Siapa?</label>
										{!! Form::select('staf_id_complain', $staf, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'staf_id_complain'])!!}
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="">Alasan Komplain</label>
											{!! Form::textarea('complain', null, ['class' => 'form-control textareacustom', 'id' => 'complain'])!!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<button type="button" class="btn btn-success btn-block" onclick="dummy2(event);return false;">Submit</button>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<button type="button" class="btn btn-danger btn-block" onclick="cancelComplain();return false;">Cancel</button>
								</div>
							</div>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal-footer-left" id="modal-footer">
	<br />
<div class="row">
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 red text-left">
	 @include('peringatanbpjs', ['ns' => false])
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	  <div class="row">
	  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<button type="button" class="btn btn-success  btn-block" id="dummyButton">Masukkan</button>
			<input type="submit" name="submit" id="submit" class="btn btn-success displayNone" value="Masukkan"/>
	  	</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<button type="button" class="btn btn-danger btn-block" data-dismiss="modal" onclick="modalClose()">Close</button>
		</div>
		
	  </div>
  </div>
</div>
</div>
</form>
