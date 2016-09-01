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
						<input type="text" class="form-control angka" name="antrian" id="antrian" required/>
						<div id="validasiAntrian"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Poli:</label>
						{!! Form::select('poli', $poli, null, ['class' => 'form-control'])!!}
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<div class="form-group">
						<label for="recipient-name" class="control-label">Dokter</label>
						{!! Form::select('staf_id', $staf, null, [
						'class' => 'form-control selectpick',
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

<div class="modal-footer" id="modal-footer">
<div class="row">
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 red text-left">
	 @include('peringatanbpjs', ['ns' => false])
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	<button type="button" class="btn btn-success" id="dummyButton">Masukkan</button>
	<input type="submit" name="submit" id="submit" class="btn btn-success displayNone" value="Masukkan"/>
	<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="modalClose()">Close</button>
  </div>
</div>
</div>
</form>
