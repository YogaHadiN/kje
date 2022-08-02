<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="panelLeft">
						Daftar Alergi
					</div>	
					<div class="panelRight">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Alergi Obat
						</button>
					</div>
				</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Alergi</th>
								<th class="fit">Action</th>
							</tr>
						</thead>
						<tbody id="alergy_body_table">
							@if($pasien->alergies->count() > 0)
								@foreach($pasien->alergies as $alergi)
									<tr>
										<td class="nama_obat">{{ $alergi->generik->generik }}</td>
										<td nowrap class="fit">
											<button class="btn btn-danger btn-sm" onclick="deleteAlergi('{{ $alergi->id }}', this);return false;" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="2" class="text-center">Tidak ada data ditemukan</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="alert alert-success">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					@if($antrianperiksa->asuransi_id == '32')
						<span  id="labelKecelakaanKerja" data-placement="top" title="Perhatian"  data-toggle="popover" title="Popover title" data-content="Jika Pasien Kecelakaan Kerja / Kecelakaan Lalulintas, Ganti Menjadi Kecelakaan Kerja"></span> Kecelakaan Kerja / Lalu Lintas :<br>
					@else
						<span  id="labelKecelakaanKerja" data-placement="top"  data-toggle="popover" title="Popover title" data-content="Jika Pasien Kecelakaan Kerja, Ganti Menjadi Kecelakaan Kerja"></span> Kecelakaan Kerja :<br>
					@endif
					 {!! Form::select('kecelakaan_kerja', [
						null => '- pilih -',
						'1'  => 'Ya',
						'0'  => 'bukan '
					 ], $antrianperiksa->kecelakaan_kerja, [
					 'class' => 'form-control',
					 'onchange' => 'kecelakaanKerjaChange(this);return false;',
					 'id' => 'kecelakaanKerja'])!!}
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					  Pembayaran : 
					 <select name="asuransi_id" id="asuransi_id" class="form-control" onchange="asuransiIdChange(this);return false;">
						@if($antrianperiksa->asuransi_id == '0' && $antrianperiksa->pasien->asuransi_id != '0')
							<option value="0" selected>Biaya Pribadi</option>
							<option value="{!! $antrianperiksa->pasien->asuransi_id !!}">{!! $antrianperiksa->pasien->asuransi->nama !!}</option>
						@elseif($antrianperiksa->asuransi_id != '0')
							<option value="0">Biaya Pribadi</option>
							<option value="{!! $antrianperiksa->asuransi_id !!}" selected>{!! $antrianperiksa->asuransi->nama !!}</option>
						@else
							<option value="0">Biaya Pribadi</option>
						@endif                 
					 </select>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					Kehamilan : 
					 {!! Form::select('hamil', [
						null => 'tidak tau',
						'1'  => 'hamil',
						'0'  => 'tidak hamil'
					 ], $antrianperiksa->hamil, ['class' => 'form-control', 'id' => 'hamil'])!!}
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					Pemeriksa : 
					{!! Form::select('staf_id', $stafs, $antrianperiksa->staf_id, ['class' => 'form-control selectpick', 'id' => 'staf_id', 'data-live-search' => 'true'])!!}
				</div>
			</div>
		</div>
	</div>
</div>
@if($pakai_bayar_pribadi)
<div class="alert alert-danger">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Bila Pasien datang karena kontrol akibat Kecelakaan Kerja / Kecelakaan Lalu Lintas, pelayanan tersebut tidak ditanggung oleh BPJS <br>
            Pilih Salah Satu Dibawah ini sebelum melanjutkan : <br>
            <strong>Apakah Pasien datang untuk kontrol karena Kecelakaan Lalu Lintas / Kecelakaan Kerja?</strong>
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-success btn-block btn-lg" type="button" value="0" onclick="asuransiIdChange(this);return false;">Kecelakaan Kerja / Lalu Lintas</button>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-danger btn-block btn-lg" type="button" data-dismiss="alert" aria-label="Close">Bukan</button>            
        </div>
    </div>
</div>
@endif
@if($antrianperiksa->asuransi_id == 0 && !empty($antrianperiksa->keterangan))
    <div class="alert alert-danger">
        {{$antrianperiksa->keterangan}}
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <!-- Tab panes -->
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id='tab2panel'>
                <li role="presentation" class="active">
                    <a href="#status" aria-controls="status" role="tab" data-toggle="tab" id="tab-status">Status</a>
                </li>
                @if($antrianperiksa->poli->poli == 'Poli ANC' || $antrianperiksa->poli->poli == 'Poli USG Kebidanan')
                    <li role="presentation">
                        <a href="#anc" aria-controls="anc" role="tab" data-toggle="tab" id="tab-anc">ANC</a>
                    </li>
                @endif
                @if($antrianperiksa->poli->poli == 'Poli USG Kebidanan')
                    <li role="presentation">
                        <a href="#usg" aria-controls="usg" role="tab" data-toggle="tab" id="tab-usg">USG</a>
                    </li> 
                @endif
                <li role="presentation">
                    <a href="#resep" aria-controls="resep" role="tab" data-toggle="tab" id="tab-resep">Resep</a>
                </li>
            </ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="status">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col2">
							<div class="panel panel-primary col2">
								<div class="panel-heading">
									<div class="panelLeft">
										@if( $antrianperiksa->antrian )
											<button class="btn btn-success" type="button" onclick="panggil('{{ $antrianperiksa->antrian->id }}', 'ruangperiksasatu');return false;">
												<i class="fas fa-volume-up fa-3x"></i>
											</button>
										@endif
									</div>
									<div class="panelRight">
											<a target="_blank" class="btn btn-primary btn-sm" href="https://api.whatsapp.com/send?phone={{ preg_replace("/^0?/", "+62", $antrianperiksa->pasien->no_telp) }}&text=Selamat%20{{ App\Models\Classes\Yoga::whatDay() }}%20saya%20{{ rawurlencode( $antrianperiksa->staf->nama ) }}%2C%20saya%20ditugaskan%20terkait%20pasien%20{{ rawurlencode($antrianperiksa->pasien->nama) }}%20yang%20berobat%20ke%20klinik.%20Ada%20yang%20bisa%20dibantu%20untuk%20keluhannya%3F%20"><i class="fab fa-whatsapp fa-3x"></i></a>
									</div>
								</div>
								<div class="panel-body">
									{!! Form::text('kali_obat', $antrianperiksa->asuransi->kali_obat, ['class' => 'hide', 'id' => 'kali_obat'])!!}
									{!! Form::text('pasien_id', $antrianperiksa->pasien_id, ['class' => 'displayNone', 'id' => 'pasien_id']) !!}
									{!! Form::text('jam', $antrianperiksa->jam, ['class' => 'displayNone']) !!}
									{!! Form::text('notified', $antrianperiksa->staf->notified, ['class' => 'displayNone', 'id' => 'notified']) !!}
									{!! Form::text('_token', Session::token(), ['class' => 'displayNone', 'id'=>'token']) !!}
									{!! Form::text('jam_periksa', date('H:i:s'), ['class' => 'displayNone']) !!}
									{!! Form::text('tanggal', $antrianperiksa->tanggal, ['class' => 'displayNone']) !!}
									{!! Form::text('bukan_peserta', $antrianperiksa->bukan_peserta, ['class' => 'displayNone']) !!}
									{!! Form::text('poli_id', $antrianperiksa->poli_id, ['class' => 'displayNone', 'id' => 'poli_id']) !!}
									{!! Form::text('adatindakan', $adatindakan, ['class' => 'hide', 'id' => 'adatindakan']) !!}
									{!! Form::text('asisten_id', $antrianperiksa->asisten_id, ['class' => 'hide']) !!}
									{!! Form::text('periksa_awal', $antrianperiksa->periksa_awal, ['class' => 'hide']) !!}
									{!! Form::text('antrian_periksa_id', $antrianperiksa->id, ['class' => 'displayNone', 'id' => 'antrianperiksa_id']) !!}
									{!! Form::text('antrian_id', $antrian_id, ['class' => 'displayNone', 'id' => 'antrian_id']) !!}
									{!! Form::text('keterangan_periksa', $antrianperiksa->keterangan, ['class' => 'displayNone']) !!}
									{!! Form::text('dibantu', '1', ['class' => 'form-control hide', 'id' => 'dibantu'])!!}
									{!! Form::text('antrian', $antrianperiksa->antrian, ['class' => 'displayNone']) !!}
									<div class="row">
										{!! Form::text('berat_badan', $berat_badan, ['class' => 'form-control hide', 'id' => 'berat_badan'])!!}
										@if ( $dikasiDalam1BulanTerakhir > 0 )
											<div class="alert alert-danger">
												Pasien sudah mendapatkan surat sakit {{ $dikasiDalam1BulanTerakhir }} kali dalam 30 hari terakhir
												<a target="_blank" class="btn btn-info btn-xs" href="{{ url('suratsakits/show/' . $antrianperiksa->pasien_id) }}">Riwayat</a>
											</div>
										@endif
										<div class="col-lg-12 col-md-12">
											<div class="form-group @if($errors->has('anamnesa'))has-error @endif">
											  {!! Form::label('anamnesa', 'Anamnesa', ['class' => 'control-label']) !!}
											  {!! Form::textarea('anamnesa', null, ['class' => 'form-control textareacustom', 'id' => 'anamnesa'])!!}
											  @if($errors->has('anamnesa'))<code>{{ $errors->first('anamnesa') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<div class="form-group @if($errors->has('sistolik'))has-error @endif">
											  {!! Form::label('sistolik', 'Sistolik', ['class' => 'control-label']) !!}
											  {!! Form::text('sistolik' , $sistolik, ['class' => 'form-control angka']) !!}
											  @if($errors->has('sistolik'))<code>{{ $errors->first('sistolik') }}</code>@endif
											</div>
										</div>
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<div class="form-group @if($errors->has('diastolik'))has-error @endif">
											  {!! Form::label('diastolik', 'Diastolik', ['class' => 'control-label']) !!}
											  {!! Form::text('diastolik' , $diastolik, ['class' => 'form-control angka']) !!}
											  @if($errors->has('diastolik'))<code>{{ $errors->first('diastolik') }}</code>@endif
											</div>
										</div>
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<div class="form-group @if($errors->has('mmHg'))has-error @endif">
												<br />
												<br />
											  {!! Form::label('mmHg', 'mmHg', ['class' => 'control-label']) !!}
											  @if($errors->has('mmHg'))<code>{{ $errors->first('mmHg') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group @if($errors->has('pemeriksaanFisik'))has-error @endif">
											  {!! Form::label('pemeriksaanFisik', 'Pemeriksaan Fisik', ['class' => 'control-label']) !!}
											  {!! Form::textarea('pemeriksaan_fisik', $pemeriksaan_awal, ['class' => 'form-control textareacustom', 'id' => 'pemeriksaan_fisik'])!!}
											  @if($errors->has('pemeriksaanFisik'))<code>{{ $errors->first('pemeriksaanFisik') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group @if($errors->has('pemeriksaan_penunjang'))has-error @endif">
											    {!! Form::label('pemeriksaan_penunjang', 'Pemeriksaan Penunjang, Injeksi dan Tindakan', ['class' => 'control-label']) !!}
												{!! Form::textarea('pemeriksaan_penunjang', $penunjang, ['class' => 'form-control textareacustom', 'id' => 'pemeriksaan_penunjang'])!!}
											  @if($errors->has('pemeriksaan_penunjang'))<code>{{ $errors->first('pemeriksaan_penunjang') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group @if($errors->has('diagnosa_id'))has-error @endif">
												<label for="diagnosa_id" id="lblDiagnosa" class="control-label" data-placement="left"  data-toggle="popover" title="Popover title" data-content="Jika ASMA BERAT, berikan bersama dexa inj IV 2 ampul, dan prednison dosis tinggi, Decafil 20 tablet, termasuk untuk pasien BPJS">Diagnosa</label><br />
													<div class="input-group">
														{!! Form::select('diagnosa_id', $diagnosa, null, [
															'class'             => 'selectpick form-control',
															'data-live-search'  => 'true',
															'aria-describedby'  => 'showModal1',
															'title'             => 'Perhatikan ICD 10',
															'onchange'          => 'diagnosaChange();return false;',
															'id'                => 'ddlDiagnosa'
														]) !!}
														<span class="input-group-addon anchor" id="showModal1" data-toggle="modal" data-target="#exampleModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
													</div>
												  @if($errors->has('diagnosa_id'))<code>{{ $errors->first('diagnosa_id') }}</code>@endif
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="keterangan_boleh_dirujuk">

										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<div class="form-group @if($errors->has('keterangan_diagnosa'))has-error @endif">
											  {!! Form::label('keterangan_diagnosa', 'Keterangan Diagnosa dan Diagnosa Tambahan', ['class' => 'control-label']) !!}
											  {!! Form::text('keterangan_diagnosa', null, ['class' => 'form-control', 'id' => 'keterangan_diagnosa'])!!}
											  @if($errors->has('keterangan_diagnosa'))<code>{{ $errors->first('keterangan_diagnosa') }}</code>@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                        @if($antrianperiksa->poli->poli != 'Poli Estetika')
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col2">
								<div class="panel panel-info col2">
									<div class="panel-heading">
										<h3>Pembayaran : {!! $antrianperiksa->asuransi->nama !!}</h3>
									</div>
									<div class="panel-body" id="peringatan_pembayaran">
										@if($antrianperiksa->asuransi->umum != ''  && $antrianperiksa->asuransi->umum != '[]' && $antrianperiksa->asuransi->umum != null)
										   @foreach(json_decode($antrianperiksa->asuransi->umum, true) as $ket)
												<p>
													{!! $ket !!}
												</p>
										   @endforeach
										@else
										<h2 class="text-center">Tidak ada catatan penting</h2>
									   @endif
									</div>
								</div>
							</div>
						@else
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col2">
								<div class="panel panel-info col2">
									<div class="panel-heading">
										<h3>Tangkapan Foto</h3>
									</div>
									<div class="panel-body" id="panel_gambar">
									</div>
									@include('tambah_gambar')
								</div>
							</div>
						@endif
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="usg">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3>Formulir USG</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<div class="table-responsive">
												<table class="table table-condensed">
													<tbody>
														<tr>
															<td>Presentasi</td>
															<td colspan="3">{!! Form::text('presentasi', $presentasi, ['class' => 'form-control hasil', 'id' =>'usg_presentasi'])!!}</td>
														</tr>
														<tr>
															<td>Biparietal Diameter</td>
															<td>
																<div class="input-group">
																	{!! Form::text('BPD_w', $BPD_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'BPD_w'])!!}
																	<span class="input-group-addon" id="addonBPDw">W</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('BPD_d', $BPD_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'BPD_d' ])!!}
																	<span class="input-group-addon" id="addonBPDd">D</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('BPD_mm', $BPD_mm, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'BPD_mm' ])!!}
																	<span class="input-group-addon" id="addonBPDmm">mm</span>
																</div>
															</td>
														</tr>
														<tr>
															<td>Head Circumference</td>
															<td>
																<div class="input-group">
																	{!! Form::text('HC_w', $HC_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'HC_w'])!!}
																	<span class="input-group-addon" id="addonHCw">W</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('HC_d', $HC_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'HC_d' ])!!}
																	<span class="input-group-addon" id="addonHCd">D</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('HC_mm', $HC_mm, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'HC_mm' ])!!}
																	<span class="input-group-addon" id="addonHCmm">mm</span>
																</div>
															</td>
														</tr>
														<tr>
															<td>LTP</td>
															<td>
																<div class="input-group">
																	{!! Form::text('LTP', $LTP, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_ltp'])!!}
																	<span class="input-group-addon" id="addonLTP">lilitan</span>
																</div>
															</td>
															<td>FHR</td>
															<td>
																<div class="input-group">
																	{!! Form::text('FHR', $FHR, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_djj'])!!}
																	<span class="input-group-addon" id="addonFHR">bpm</span>
																</div>
															</td>
														</tr>
														<tr>
															<td>Abdominal Circumference</td>
															<td>
																<div class="input-group">
																	{!! Form::text('AC_w', $AC_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'AC_w'])!!}
																	<span class="input-group-addon" id="addonACw">W</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('AC_d', $AC_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'AC_d'])!!}
																	<span class="input-group-addon" id="addonACd">D</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('AC_mm', $AC_mm, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'AC_mm'])!!}
																	<span class="input-group-addon" id="addonACmm">mm</span>
																</div>
															</td>
														</tr>
														
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<div class="table-responsive">
												<table class="table table-condensed">
													<tbody>
														<tr>
															<td>Estimated Fetal Weight</td>
															<td colspan="3">
																<div class="input-group">
																	{!! Form::text('EFW', $EFW, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_efw'])!!}
																	<span class="input-group-addon" id="addonEFW">gram</span>
																</div>
															</td>
														</tr>
														<tr>
															<td>Femur Length</td>
															<td>
																<div class="input-group">
																	{!! Form::text('FL_w', $FL_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'FL_w'])!!}
																	<span class="input-group-addon" id="addonFLw">W</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('FL_d', $FL_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'FL_d'])!!}
																	<span class="input-group-addon" id="addonFLd">D</span>
																</div>
															</td>
															<td>
																<div class="input-group">
																	{!! Form::text('FL_mm', $FL_mm, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'FL_mm'])!!}
																	<span class="input-group-addon" id="addonFLmm">mm</span>
																</div>
															</td>
														</tr>
														<tr>
															<td>Sex</td>
															<td colspan="3">
																{!! Form::select('Sex',
																[
																	'tak dpt dinilai' => 'tak dpt dinilai',
																	'kemungkinan laki-laki' => 'Laki-Laki',
																	'kemungkinan perempuan' => 'Perempuan'
																]
																, $Sex, ['class' => 'form-control hasil', 'id' => 'usg_sex'])!!}
															</td>
														</tr>
														<tr>
															<td>Plasenta</td>
															<td colspan="3">
																{!! Form::text('Plasenta', $Plasenta, ['class' => 'form-control hasil', 'id' => 'usg_plasenta'])!!}
															</td>
														</tr>
														<tr>
															<td>Total</td>
															<th>
																{!! Form::text('total_afi', $total_afi, ['class' => 'form-control hasil', 'id' => 'total_afi'])!!}
															</th>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
												{!! Form::label('kesimpulan')!!}
												{!! Form::textarea('kesimpulan', $kesimpulan, ['class' => 'form-control textareacustom'])!!}
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
												{!! Form::label('saran')!!}
												{!! Form::text('saran', $saran, ['class' => 'form-control'])!!}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="resep">
					<div class="row">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
							<div id="resume"></div>
							@include('perscribe', ['showSubmit' => false, 'berat_badan_input' => $antrianperiksa->berat_badan, 'transaksi' => $transaksi])
						</div><!-- .col 7 -->
						<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id='peringatan'>
									
								</div>
							</div>
							@if($antrianperiksa->asuransi->tipe_asuransi_id == '4')
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id='bilaTipeFlat'>
										<div class="alert alert-success">
											<ul>
												<li>
													Plafon obat yang bisa digunakan sekarang :<br /><span class="strong uang" id="plafon"> {!! $plafon['plafon'] !!}</span>
												</li>
												<li>
													Jumlah Pasien {{ $antrianperiksa->asuransi->nama }} saat ini : <br /><strong>{{ $plafon['kunjungan'] }}</strong>
												</li>
												<li>
													Jumlah Dibayar Tunai {{ $antrianperiksa->asuransi->nama }} saat ini : <br /><strong class="uang">{{ $plafon['tunai'] }}</strong>
												</li>
												<li>
													Jumlah Utilisasi Obat {{ $antrianperiksa->asuransi->nama }} saat ini : <br /><strong class="uang">{{ $plafon['utilisasi'] }}</strong>
												</li>
											</ul>
										</div>
										<input type="text" id="plafon_total" value="{!!$plafon['plafon']!!}" class="hide">
									</div>
								</div>
							@endif
							@if($antrianperiksa->asuransi_id == '32')
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
										<div class="panel panel-info">
											<div class="panel-heading">Obat yang tidak ditanggung BPJS</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-condensed">
														<thead>
															<tr>
																<th>Obat</th>
																<th>Jumlah</th>
															</tr>
														</thead>
														<tbody id='bilaTipeBPJS'>

														</tbody>
														<tfoot>
															<tr>
																<td>Total </td>
																<td id="totalBilaTipeBPJS" class="uang"></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
										<div class="panel panel-primary">
											<div class="panel-heading">Tindakan yang tidak ditanggung BPJS</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table class="table table-condensed">
														<thead>
															<tr>
																<th>Tindakan</th>
																<th>Biaya</th>
															</tr>
														</thead>
														<tbody id='dibayarTIndakanBpjs'>

														</tbody>
														<tfoot>
															<tr>
																<td>Total </td>
																<td id="TotalDibayarTindakanBPJS" class="uang"></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="alert alert-danger" id="adaYangDibayar" style="display:none;">
									<h2>Total Yand Dibayar</h2>
									<strong><h1 class="uang" id="jumlahDibayarBpjs"></h1></strong>
								</div>
								<div class="row hide" id="kekuranganFlat">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="panel panel-danger">
											<div class="panel-heading">
												<h3 class="panel-title">Panel title</h3>
											</div>
											<div class="panel-body">
													<h3>Ada Biaya Tambahan Senilai</h3> 
												<h2 class="uang" id="uangKekuranganFlat">
													
												</h2>
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							{!! Form::submit('Submitsss', [
							'class' => 'displayNone',
							'id' => 'submitFormPeriksa'])!!}
							<button type="button" class="btn btn-success btn-lg btn-block" id="LinkButton2" >Submit</button>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli->poli )!!}" class="btn btn-danger btn-lg btn-block">Cancel</a>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="anc">
					@include('anc')
				</div>
			</div>
        </div>
    </div>
</div>
@if($antrianperiksa->asuransi_id == '32')
	<div class="modal" id="cekFoto">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="text-center">{!! $antrianperiksa->pasien->nama!!}, {!! App\Models\Classes\Yoga::datediff($antrianperiksa->pasien->tanggal_lahir->format('Y-m-d'), date('Y-m-d'))!!}</h4>
				</div>
				<div class="modal-body text-center">
					<img src="{{ \Storage::disk('s3')->url($antrianperiksa->pasien->image) }}" alt="" width="500px" height="375px">
					<h4 class="text-center">Jika foto pasien tidak cocok, minta pasien untuk mendaftar lagi sebagai pasien umum</h4>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button type="button" class="btn btn-lg btn-success btn-block" onclick="fokusKeAnemnesa(); return false;">Benar</button>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a href="{!! url('ruangperiksa/' . $antrianperiksa->poli_id) !!}" class="btn btn-lg btn-danger btn-block">Tidak Benar</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
<div></div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
		  <div class="form-group @if($errors->has('gener')) has-error @endif">
		    {!! Form::label('generik_id', 'Nama Generik', ['class' => 'control-label']) !!}
			{!! Form::select('generik_id' , $generik_list, null, [ 'data-live-search' => 'true', 'class' => 'form-control selectpick', 'onchange' => 'generik_list_change();return false;', 'id' => 'generik_list_alergi']) !!}
		    @if($errors->has('generik_id'))<code>{{ $errors->first('generik_id') }}</code>@endif
		  </div>
		  {{-- {!! Form::text('id_poli', $antrianperiksa->id, ['class' => 'form-control hide', 'id' => ]) !!} --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        <button type="button" class="btn submit_button btn-primary disabled" onclick="submitAlergi(this);return false;">Simpan Alergi Obat</button>
      </div>
    </div>
  </div>
</div>
