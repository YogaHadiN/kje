<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Panel Riwayat</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				@include('antrianpolis.gpa', [
					'g' => $g,
					'p' => $p,
					'a' => $a
				])
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
			 		{!! Form::label('hpht', 'HPHT')!!}
					{!! Form::text('hpht', $hpht, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonhpht', 'dir' => 'rtl', 'id' => 'hpht'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('uk', 'Umur Kehamilan')!!}
					{!! Form::text('uk', $uk, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'uk', 'id' => 'uk'])!!}
				</div>
            </div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			 	<div class="form-group">
			 		{!! Form::label('tb', 'Tinggi Badan')!!}
					 <div class="input-group">
						{!! Form::text('tb', $tb, ['id' => 'tb','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addontb', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addontb">cm</span>
				 	</div>`
                </div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			 	<div class="form-group">
			 		{!! Form::label('jumlah_janin')!!}
					 <div class="input-group">
					 	@if($antrianperiksa->poli == 'usg')
						{!! Form::text('jumlah_janin', $jumlah_janin, ['id' => 'jumlah_janin','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonjumlah_janin', 'dir' => 'rtl', 'readonly' => 'readonly'])!!}
						@else
						{!! Form::text('jumlah_janin', $jumlah_janin, ['id' => 'jumlah_janin','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonjumlah_janin', 'dir' => 'rtl'])!!}
						@endif
	                    <span class="input-group-addon" id="addonjumlah_janin">janin</span>
				 	</div>
                </div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				{!! Form::label('status_imunisasi_tt_id', 'Status Imunisasi TT')!!}
				{!! Form::select('status_imunisasi_tt_id', $confirms, $status_imunisasi_tt_id, ['class' => 'form-control panelRiwayat'])!!}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				{!! Form::label('nama_suami')!!}
				{!! Form::text('nama_suami', $nama_suami, ['class' => 'form-control panelRiwayat']) !!}
				
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				{!! Form::label('buku') !!}
				{!! Form::select('buku', $bukus, $buku, ['class' => 'form-control panelRiwayat'])!!}
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				{!! Form::label('bb_sebelum_hamil') !!}
				 <div class="input-group">
					{!! Form::text('bb_sebelum_hamil', $bb_sebelum_hamil, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonBbSebelumHamil'])!!}
                    <span class="input-group-addon" id="addonBbSebelumHamil">kg</span>
			 	</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('tanggal_lahir_anak_terakhir')!!}
					{!! Form::text('tanggal_lahir_anak_terakhir', $tanggal_lahir_anak_terakhir, ['class' => 'form-control panelRiwayat tanggal', 'id' => 'tanggal_lahir_anak_terakhir']) !!}
					{{-- {!! Form::text('tanggal_lahir_anak_terakhir', App\Classes\Yoga::updateDatePrep($tanggal_lahir_anak_terakhir), ['class' => 'form-control panelRiwayat tanggal', 'id' => 'tanggal_lahir_anak_terakhir']) !!} --}}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('golongan_darah')!!}
					{!! Form::select('golongan_darah', App\Classes\Yoga::golonganDarahList() , $golongan_darah, ['class' => 'form-control panelRiwayat', 'id' => 'golongan_darah']) !!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('rencana_penolong')!!}
					{!! Form::text('rencana_penolong', $rencana_penolong, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_penolong']) !!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('rencana_tempat')!!}
					{!! Form::text('rencana_tempat', $rencana_tempat, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_tempat']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('rencana_pendamping')!!}
					{!! Form::text('rencana_pendamping', $rencana_pendamping, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_pendamping']) !!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('rencana_transportasi')!!}
					{!! Form::text('rencana_transportasi', $rencana_transportasi, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_transportasi']) !!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('rencana_pendonor')!!}
					{!! Form::text('rencana_pendonor', $rencana_pendonor, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_pendonor']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3>Riwayat Obstetri</h3>
	</div>
	<div class="panel-body">
		@include('antrianpolis.riwobs')
	</div>
</div>
<div class="panel panel-info">
	<div class="panel-heading">
		<h4>Pemeriksaan Umum</h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			 	<div class="form-group">
			 		{!! Form::label('td', 'Tekanan Darah')!!}
					 <div class="input-group">
						{!! Form::text('td', $td, ['class' => 'form-control', 'aria-describedby' => 'addonTekananDarah', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonTekananDarah">mmHg</span>
				 	</div>
                </div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			 	<div class="form-group">
			 		{!! Form::label('bb', 'Berat Badan')!!}
					 <div class="input-group">
						{!! Form::text('bb', $bb, ['class' => 'form-control', 'aria-describedby' => 'addonbb', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonbb">kg</span>
				 	</div>
                </div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			 	<div class="form-group">
			 		{!! Form::label('tfu', 'Tinggi Fundus Uteri')!!}
					 <div class="input-group">
						{!! Form::text('tfu', $tfu, ['class' => 'form-control', 'aria-describedby' => 'addOnTfu', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addOnTfu">cm</span>
				 	</div>
	            </div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			 	<div class="form-group">
			 		{!! Form::label('lila', 'Lingkar Lengan Atas')!!}
					 <div class="input-group">
						{!! Form::text('lila', $lila, ['class' => 'form-control', 'aria-describedby' => 'addonlila', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonlila">cm</span>
				 	</div>
                </div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('refleks_patela', 'Refleks Patela')!!}
					{!! Form::select('refleks_patela', $refleks_patelas, $refleks_patela, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			 	<div class="form-group">
			 		{!! Form::label('djj', 'DJJ/FHR')!!}
					 <div class="input-group">
					 	@if($antrianperiksa->poli == 'usg')
						{!! Form::text('djj', $djj, ['class' => 'form-control', 'aria-describedby' => 'addOndjj', 'dir' => 'rtl', 'readonly' => 'readonly'])!!}
						@else
						{!! Form::text('djj', $djj, ['class' => 'form-control', 'aria-describedby' => 'addOndjj', 'dir' => 'rtl'])!!}
						@endif
	                    <span class="input-group-addon" id="addOndjj">bpm</span>
				 	</div>
	            </div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('kepala_terhadap_pap_id', 'Kepala Terhadap PAP')!!}
					{!! Form::select('kepala_terhadap_pap_id', $kepala_terhadap_paps, $kepala_terhadap_pap_id, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('presentasi_id', 'Presentasi')!!}
					@if($antrianperiksa->poli == 'usg')
					{!! Form::select('presentasi_id', $presentasis, $presentasi_id, ['class' => 'form-control presentasi', 'disabled' => 'disabled'])!!}
					{!! Form::hidden('presentasi_id', $presentasi_id, ['class' => 'form-control presentasi'])!!}
					@else
					{!! Form::select('presentasi_id', $presentasis, $presentasi_id, ['class' => 'form-control'])!!}
					@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group" @if($errors->has('perujuk_id')) class="has-error" @endif)>
				  {!! Form::label('perujuk_id', 'Perujuk') !!}
				  {!! Form::select('perujuk_id' , App\Classes\Yoga::perujukList(), $perujuk_id, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
				  @if($errors->has('perujuk_id'))<code>{{ $errors->first('perujuk_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
					{!! Form::label('buat_perujuk', 'Perujuk Tidak Ditemukan ?') !!}
					<button class="btn btn-block btn-success" type="button" onclick=" $('#modal_buat_perujuk_baru').modal('show'); ">Buat Perujuk Baru</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3>Pelayanan Umum</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('catat_di_kia')!!}
					{!! Form::select('catat_di_kia', $confirms, $catat_di_kia, ['class' => 'form-control'])!!}
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('inj_tt')!!}
					{!! Form::select('inj_tt', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('fe_tablet')!!}
					{!! Form::select('fe_tablet', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3>Laboratorium Umum</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('periksa_hb')!!}
					{!! Form::select('periksa_hb', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('protein_urin')!!}
					{!! Form::select('protein_urin', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('gula_darah')!!}
					{!! Form::select('gula_darah', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('thalasemia')!!}
					{!! Form::select('thalasemia', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('sifilis')!!}
					{!! Form::select('sifilis', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('hbsag')!!}
					{!! Form::select('hbsag', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
		</div>
	</div>
</div>
<div class="panel panel-warning">
	<div class="panel-heading">
		<h3>Panel Komplikasi</h3>
	</div>
	<div class="panel-body hide-panel">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('komplikasi_hdk')!!}
					{!! Form::select('komplikasi_hdk', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('komplikasi_abortus')!!}
					{!! Form::select('komplikasi_abortus', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('komplikasi_perdarahan')!!}
					{!! Form::select('komplikasi_perdarahan', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
            </div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('komplikasi_infeksi')!!}
					{!! Form::select('komplikasi_infeksi', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
            </div>
		</div>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('komplikasi_kpd')!!}
					{!! Form::select('komplikasi_kpd', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div> 
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<div class="form-group">
					{!! Form::label('komplikasi_lain_lain')!!}
					{!! Form::text('komplikasi_lain_lain', null, ['class' => 'form-control'])!!}
				</div>
            </div>
		</div>
	</div>
</div>
<div class="panel panel-danger">
	<div class="panel-heading">
		<h3>Panel HIV</h3>
	</div>
	<div class="panel-body hide-panel">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('pmtct_konseling')!!}
					{!! Form::select('pmtct_konseling', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('pmtct_periksa_darah')!!}
					{!! Form::select('pmtct_periksa_darah', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('pmtct_serologi')!!}
					{!! Form::select('pmtct_serologi', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group">
					{!! Form::label('pmtct_arv')!!}
					{!! Form::select('pmtct_arv', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
		    </div>
		</div>
	</div>
</div>
<div class="panel panel-danger">
		<div class="panel-heading">
			<h3>Panel Malaria</h3>
		</div>
		<div class="panel-body hide-panel">
			<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group">
						{!! Form::label('malaria_periksa_darah')!!}
						{!! Form::select('malaria_periksa_darah', $confirms, 2, ['class' => 'form-control'])!!}
					</div>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group">
						{!! Form::label('malaria_positif')!!}
						{!! Form::select('malaria_positif', $confirms, 2, ['class' => 'form-control'])!!}
					</div>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group">
						{!! Form::label('malaria_dikasih_obat')!!}
						{!! Form::select('malaria_dikasih_obat', $confirms, 2, ['class' => 'form-control'])!!}
					</div>
	            </div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="form-group">
						{!! Form::label('malaria_dikasih_kelambu')!!}
						{!! Form::select('malaria_dikasih_kelambu', $confirms, 2, ['class' => 'form-control'])!!}
					</div>
	            </div>
			</div>
		</div>
	</div>	
<div class="panel panel-danger">
	<div class="panel-heading">
		<h3>Panel TBC</h3>
	</div>
	<div class="panel-body hide-panel">
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('tbc_periksa_dahak')!!}
					{!! Form::select('tbc_periksa_dahak', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('tbc_positif')!!}
					{!! Form::select('tbc_positif', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group">
					{!! Form::label('tbc_dikasih_obat')!!}
					{!! Form::select('tbc_dikasih_obat', $confirms, 2, ['class' => 'form-control'])!!}
				</div>
            </div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_buat_perujuk_baru">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Buat Perujuk Baru</h4>
	  </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group" @if($errors->has('nama_perujuk')) class="has-error" @endif)>
				  {!! Form::label('nama_perujuk', 'Nama') !!}
				  {!! Form::text('nama_perujuk' , null, ['class' => 'form-control', 'id' => 'nama_perujuk']) !!}
				  @if($errors->has('nama_perujuk'))<code>{{ $errors->first('nama_perujuk') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group" @if($errors->has('alamat_perujuk')) class="has-error" @endif)>
				  {!! Form::label('alamat_perujuk', 'Alamat') !!}
				  {!! Form::textarea('alamat_perujuk' , null, ['class' => 'form-control textareacustom', 'id' => 'alamat_perujuk']) !!}
				  @if($errors->has('alamat_perujuk'))<code>{{ $errors->first('alamat_perujuk') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group" @if($errors->has('no_telp_perujuk')) class="has-error" @endif)>
				  {!! Form::label('no_telp_perujuk', 'No Telp') !!}
				  {!! Form::text('no_telp_perujuk' , null, ['class' => 'form-control', 'id' => 'no_telp_perujuk']) !!}
				  @if($errors->has('no_telp_perujuk'))<code>{{ $errors->first('no_telp_perujuk') }}</code>@endif
				</div>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		  <div class="row">
		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button type="button" class="btn btn-primary btn-block" id="dummy_submit_perujuk_baru">Buat Perujuk Baru</button>
				<button type="button" id='submit_perujuk_baru' class="btn btn-primary btn-block hide">Buat Perujuk Baru</button>
		  	</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
			</div>
		  </div>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

