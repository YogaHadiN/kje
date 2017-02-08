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
				
				<div class="form-group @if($errors->has('hpht'))has-error @endif">
				  {!! Form::label('hpht', 'HPHT', ['class' => 'control-label']) !!}
				  {!! Form::text('hpht', $hpht, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonhpht', 'dir' => 'rtl', 'id' => 'hpht'])!!}
				  @if($errors->has('hpht'))<code>{{ $errors->first('hpht') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('uk'))has-error @endif">
				  {!! Form::label('uk', 'Umur Kehamilan', ['class' => 'control-label']) !!}
					{!! Form::text('uk', $uk, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'uk', 'id' => 'uk'])!!}
				  @if($errors->has('uk'))<code>{{ $errors->first('uk') }}</code>@endif
				</div>
            </div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('tb'))has-error @endif">
				  {!! Form::label('tb', 'Tinggi Badan', ['class' => 'control-label']) !!}
					<div class="input-group">
						{!! Form::text('tb', $tb, ['id' => 'tb','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addontb', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addontb">cm</span>
				 	</div>
				  @if($errors->has('tb'))<code>{{ $errors->first('tb') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('jumlah_janin'))has-error @endif">
				  {!! Form::label('jumlah_janin', 'Jumlah Janin', ['class' => 'control-label']) !!}
					 <div class="input-group">
					 	@if($antrianperiksa->poli == 'usg')
						{!! Form::text('jumlah_janin', $jumlah_janin, ['id' => 'jumlah_janin','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonjumlah_janin', 'dir' => 'rtl', 'readonly' => 'readonly'])!!}
						@else
						{!! Form::text('jumlah_janin', $jumlah_janin, ['id' => 'jumlah_janin','class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonjumlah_janin', 'dir' => 'rtl'])!!}
						@endif
	                    <span class="input-group-addon" id="addonjumlah_janin">janin</span>
				 	</div>
				  @if($errors->has('jumlah_janin'))<code>{{ $errors->first('jumlah_janin') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('status_imunisasi_tt_id'))has-error @endif">
				  {!! Form::label('status_imunisasi_tt_id', 'Status Imunisasi TT', ['class' => 'control-label']) !!}
				  {!! Form::select('status_imunisasi_tt_id', $confirms, $status_imunisasi_tt_id, ['class' => 'form-control panelRiwayat'])!!}
				  @if($errors->has('status_imunisasi_tt_id'))<code>{{ $errors->first('status_imunisasi_tt_id') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('nama_suami'))has-error @endif">
				  {!! Form::label('nama_suami', 'Nama Suami', ['class' => 'control-label']) !!}
			    	{!! Form::text('nama_suami', $nama_suami, ['class' => 'form-control panelRiwayat']) !!}
				  @if($errors->has('nama_suami'))<code>{{ $errors->first('nama_suami') }}</code>@endif
				</div>
				
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('buku'))has-error @endif">
				  {!! Form::label('buku', 'Buku', ['class' => 'control-label']) !!}
				  {!! Form::select('buku', $bukus, $buku, ['class' => 'form-control panelRiwayat'])!!}
				  @if($errors->has('buku'))<code>{{ $errors->first('buku') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('bb_sebelum_hamil'))has-error @endif">
				  {!! Form::label('bb_sebelum_hamil', 'BB Sebelum Hamil', ['class' => 'control-label']) !!}
				 <div class="input-group">
					{!! Form::text('bb_sebelum_hamil', $bb_sebelum_hamil, ['class' => 'form-control panelRiwayat', 'aria-describedby' => 'addonBbSebelumHamil'])!!}
                    <span class="input-group-addon" id="addonBbSebelumHamil">kg</span>
			 	</div>
				  @if($errors->has('bb_sebelum_hamil'))<code>{{ $errors->first('bb_sebelum_hamil') }}</code>@endif
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('tanggal_lahir_anak_terakhir'))has-error @endif">
				  {!! Form::label('tanggal_lahir_anak_terakhir', 'Tanggal Lahir Anak Terakhir', ['class' => 'control-label']) !!}
				  {!! Form::text('tanggal_lahir_anak_terakhir', $tanggal_lahir_anak_terakhir, ['class' => 'form-control panelRiwayat tanggal', 'id' => 'tanggal_lahir_anak_terakhir']) !!}
				  @if($errors->has('tanggal_lahir_anak_terakhir'))<code>{{ $errors->first('tanggal_lahir_anak_terakhir') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('golongan_darah'))has-error @endif">
				  {!! Form::label('golongan_darah', 'Golongan Darah', ['class' => 'control-label']) !!}
				  {!! Form::select('golongan_darah', App\Classes\Yoga::golonganDarahList() , $golongan_darah, ['class' => 'form-control panelRiwayat', 'id' => 'golongan_darah']) !!}
				  @if($errors->has('golongan_darah'))<code>{{ $errors->first('golongan_darah') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('rencana_penolonga'))has-error @endif">
				  {!! Form::label('rencana_penolonga', 'Rencana Penolong', ['class' => 'control-label']) !!}
				  {!! Form::text('rencana_penolong', $rencana_penolong, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_penolong']) !!}
				  @if($errors->has('rencana_penolonga'))<code>{{ $errors->first('rencana_penolonga') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('rencana_tempat'))has-error @endif">
				  {!! Form::label('rencana_tempat', 'Rencana Tempat', ['class' => 'control-label']) !!}
				  {!! Form::text('rencana_tempat', $rencana_tempat, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_tempat']) !!}
				  @if($errors->has('rencana_tempat'))<code>{{ $errors->first('rencana_tempat') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('rencana_pendamping'))has-error @endif">
				  {!! Form::label('rencana_pendamping', 'Rencana Pendamping', ['class' => 'control-label']) !!}
				  {!! Form::text('rencana_pendamping', $rencana_pendamping, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_pendamping']) !!}
				  @if($errors->has('rencana_pendamping'))<code>{{ $errors->first('rencana_pendamping') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('rencana_transportasi'))has-error @endif">
				  {!! Form::label('rencana_transportasi', 'Rencana Transportasi', ['class' => 'control-label']) !!}
				  {!! Form::text('rencana_transportasi', $rencana_transportasi, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_transportasi']) !!}
				  @if($errors->has('rencana_transportasi'))<code>{{ $errors->first('rencana_transportasi') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('rencana_pendonor'))has-error @endif">
				  {!! Form::label('rencana_pendonor', 'Rencana Pendonor', ['class' => 'control-label']) !!}
				  {!! Form::text('rencana_pendonor', $rencana_pendonor, ['class' => 'form-control panelRiwayat', 'id' => 'rencana_pendonor']) !!}
				  @if($errors->has('rencana_pendonor'))<code>{{ $errors->first('rencana_pendonor') }}</code>@endif
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
	<h4>Pemeriksaan Umum </h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group @if($errors->has('td'))has-error @endif">
				  {!! Form::label('td', 'Tekanan Darah', ['class' => 'control-label']) !!}
					 <div class="input-group">
					 {!! Form::text('td', $antrianperiksa->sistolik . '/' . $antrianperiksa->diastolik , ['class' => 'form-control', 'aria-describedby' => 'addonTekananDarah', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonTekananDarah">mmHg</span>
				 	</div>
				  @if($errors->has('td'))<code>{{ $errors->first('td') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('bb'))has-error @endif">
				  {!! Form::label('bb', 'Berat Badan', ['class' => 'control-label']) !!}
					 <div class="input-group">
						{!! Form::text('bb', $bb, ['class' => 'form-control', 'aria-describedby' => 'addonbb', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonbb">kg</span>
				 	</div>
				  @if($errors->has('bb'))<code>{{ $errors->first('bb') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('tfu'))has-error @endif">
				  {!! Form::label('tfu', 'Tinggi Fundus Uteri', ['class' => 'control-label']) !!}
					 <div class="input-group">
						{!! Form::text('tfu', $tfu, ['class' => 'form-control', 'aria-describedby' => 'addOnTfu', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addOnTfu">cm</span>
				 	</div>
				  @if($errors->has('tfu'))<code>{{ $errors->first('tfu') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('lila'))has-error @endif">
				  {!! Form::label('lila', 'Lingkar Lengan Atas', ['class' => 'control-label']) !!}
					 <div class="input-group">
						{!! Form::text('lila', $lila, ['class' => 'form-control', 'aria-describedby' => 'addonlila', 'dir' => 'rtl'])!!}
	                    <span class="input-group-addon" id="addonlila">cm</span>
				 	</div>
				  @if($errors->has('lila'))<code>{{ $errors->first('lila') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('refleks_patela'))has-error @endif">
				  {!! Form::label('refleks_patela', 'Refleks Patela', ['class' => 'control-label']) !!}
				  {!! Form::select('refleks_patela', $refleks_patelas, $refleks_patela, ['class' => 'form-control'])!!}
				  @if($errors->has('refleks_patela'))<code>{{ $errors->first('refleks_patela') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('djj'))has-error @endif">
				  {!! Form::label('djj', 'DJJ/FHR', ['class' => 'control-label']) !!}
					 <div class="input-group">
					 	@if($antrianperiksa->poli == 'usg')
						{!! Form::text('djj', $djj, ['class' => 'form-control', 'aria-describedby' => 'addOndjj', 'dir' => 'rtl', 'readonly' => 'readonly'])!!}
						@else
						{!! Form::text('djj', $djj, ['class' => 'form-control', 'aria-describedby' => 'addOndjj', 'dir' => 'rtl'])!!}
						@endif
	                    <span class="input-group-addon" id="addOndjj">bpm</span>
				 	</div>
				  @if($errors->has('djj'))<code>{{ $errors->first('djj') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('kepala_terhadap_pap_id'))has-error @endif">
				  {!! Form::label('kepala_terhadap_pap_id', 'Kepala terhadap PAP', ['class' => 'control-label']) !!}
				  {!! Form::select('kepala_terhadap_pap_id', $kepala_terhadap_paps, $kepala_terhadap_pap_id, ['class' => 'form-control'])!!}
				  @if($errors->has('kepala_terhadap_pap_id'))<code>{{ $errors->first('kepala_terhadap_pap_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('presentasi_id'))has-error @endif">
				  {!! Form::label('presentasi_id', 'Presentasi', ['class' => 'control-label']) !!}
					@if($antrianperiksa->poli == 'usg')
					{!! Form::select('presentasi_id', $presentasis, $presentasi_id, ['class' => 'form-control presentasi', 'disabled' => 'disabled'])!!}
					{!! Form::hidden('presentasi_id', $presentasi_id, ['class' => 'form-control presentasi'])!!}
					@else
					{!! Form::select('presentasi_id', $presentasis, $presentasi_id, ['class' => 'form-control'])!!}
					@endif
				  @if($errors->has('presentasi_id'))<code>{{ $errors->first('presentasi_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				
				<div class="form-group @if($errors->has('perujuk_id'))has-error @endif">
				  {!! Form::label('perujuk_id', 'Perujuk', ['class' => 'control-label']) !!}
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
				
				<div class="form-group @if($errors->has('catat_di_kia'))has-error @endif">
				  {!! Form::label('catat_di_kia', 'Catat Di KIA', ['class' => 'control-label']) !!}
					{!! Form::select('catat_di_kia', $confirms, $catat_di_kia, ['class' => 'form-control'])!!}
				  @if($errors->has('catat_di_kia'))<code>{{ $errors->first('catat_di_kia') }}</code>@endif
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('inj_tt'))has-error @endif">
				  {!! Form::label('inj_tt', 'Injeksi TT', ['class' => 'control-label']) !!}
				  {!! Form::select('inj_tt', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('inj_tt'))<code>{{ $errors->first('inj_tt') }}</code>@endif
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('fe_tablet'))has-error @endif">
				  {!! Form::label('fe_tablet', 'Fe Tablet', ['class' => 'control-label']) !!}
				  {!! Form::select('fe_tablet', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('fe_tablet'))<code>{{ $errors->first('fe_tablet') }}</code>@endif
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
				
				<div class="form-group @if($errors->has('periksa_hb'))has-error @endif">
				  {!! Form::label('periksa_hb', 'Periksa HB', ['class' => 'control-label']) !!}
				  {!! Form::select('periksa_hb', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('periksa_hb'))<code>{{ $errors->first('periksa_hb') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('protein_urin'))has-error @endif">
				  {!! Form::label('protein_urin', 'Protein Urin', ['class' => 'control-label']) !!}
					{!! Form::select('protein_urin', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('protein_urin'))<code>{{ $errors->first('protein_urin') }}</code>@endif
				</div>
		    </div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('gula_darah'))has-error @endif">
				  {!! Form::label('gula_darah', 'Gula Darah', ['class' => 'control-label']) !!}
					{!! Form::select('gula_darah', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('gula_darah'))<code>{{ $errors->first('gula_darah') }}</code>@endif
				</div>
		    </div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('thalasemia'))has-error @endif">
				  {!! Form::label('thalasemia', 'Thalasemia', ['class' => 'control-label']) !!}
				  {!! Form::select('thalasemia', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('thalasemia'))<code>{{ $errors->first('thalasemia') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('sifilis'))has-error @endif">
				  {!! Form::label('sifilis', 'Sifilis', ['class' => 'control-label']) !!}
				  {!! Form::select('sifilis', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('sifilis'))<code>{{ $errors->first('sifilis') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="form-group @if($errors->has('hbsag'))has-error @endif">
				  {!! Form::label('hbsag', 'HbsAg', ['class' => 'control-label']) !!}
					{!! Form::select('hbsag', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('hbsag'))<code>{{ $errors->first('hbsag') }}</code>@endif
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
				
				<div class="form-group @if($errors->has('komplikasi_hdk'))has-error @endif">
				  {!! Form::label('komplikasi_hdk', 'Komplikasi HDK', ['class' => 'control-label']) !!}
					{!! Form::select('komplikasi_hdk', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_hdk'))<code>{{ $errors->first('komplikasi_hdk') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('komplikasi_abortus'))has-error @endif">
				  {!! Form::label('komplikasi_abortus', 'Komplikasi Abortus', ['class' => 'control-label']) !!}
				  {!! Form::select('komplikasi_abortus', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_abortus'))<code>{{ $errors->first('komplikasi_abortus') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('komplikasi_perdarahan'))has-error @endif">
				  {!! Form::label('komplikasi_perdarahan', 'Komplikasi Perdarahan', ['class' => 'control-label']) !!}
					{!! Form::select('komplikasi_perdarahan', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_perdarahan'))<code>{{ $errors->first('komplikasi_perdarahan') }}</code>@endif
				</div>
            </div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('komplikasi_infeksi'))has-error @endif">
				  {!! Form::label('komplikasi_infeksi', 'Komplikasi Infeksi', ['class' => 'control-label']) !!}
				  {!! Form::select('komplikasi_infeksi', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_infeksi'))<code>{{ $errors->first('komplikasi_infeksi') }}</code>@endif
				</div>
            </div>
		</div>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('komplikasi_kpd'))has-error @endif">
				  {!! Form::label('komplikasi_kpd', 'Komplikasi KPD', ['class' => 'control-label']) !!}
				  {!! Form::select('komplikasi_kpd', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_kpd'))<code>{{ $errors->first('komplikasi_kpd') }}</code>@endif
				</div>
			</div> 
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				
				<div class="form-group @if($errors->has('komplikasi_lain_lain'))has-error @endif">
				  {!! Form::label('komplikasi_lain_lain', 'Komplikasi lain-lain', ['class' => 'control-label']) !!}
				  {!! Form::text('komplikasi_lain_lain', null, ['class' => 'form-control'])!!}
				  @if($errors->has('komplikasi_lain_lain'))<code>{{ $errors->first('komplikasi_lain_lain') }}</code>@endif
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
				
				<div class="form-group @if($errors->has('pmtct_konseling'))has-error @endif">
				  {!! Form::label('pmtct_konseling', 'PMTCT Konseling', ['class' => 'control-label']) !!}
					{!! Form::select('pmtct_konseling', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('pmtct_konseling'))<code>{{ $errors->first('pmtct_konseling') }}</code>@endif
				</div>
		    </div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('pmtct_periksa_darah'))has-error @endif">
				  {!! Form::label('pmtct_periksa_darah', 'PMTCT Periksa Darah', ['class' => 'control-label']) !!}
				  {!! Form::select('pmtct_periksa_darah', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('pmtct_periksa_darah'))<code>{{ $errors->first('pmtct_periksa_darah') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('pmtct_serologi'))has-error @endif">
				  {!! Form::label('pmtct_serologi', 'PMTCT Serologi', ['class' => 'control-label']) !!}
				  {!! Form::select('pmtct_serologi', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('pmtct_serologi'))<code>{{ $errors->first('pmtct_serologi') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				
				<div class="form-group @if($errors->has('pmtct_arv'))has-error @endif">
				  {!! Form::label('pmtct_arv', 'PMTCT ARV', ['class' => 'control-label']) !!}
				  {!! Form::select('pmtct_arv', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('pmtct_arv'))<code>{{ $errors->first('pmtct_arv') }}</code>@endif
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
					
					<div class="form-group @if($errors->has('malaria_periksa_darah'))has-error @endif">
					  {!! Form::label('malaria_periksa_darah', 'Malaria Periksa Darah', ['class' => 'control-label']) !!}
						{!! Form::select('malaria_periksa_darah', $confirms, 2, ['class' => 'form-control'])!!}
					  @if($errors->has('malaria_periksa_darah'))<code>{{ $errors->first('malaria_periksa_darah') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					
					<div class="form-group @if($errors->has('malaria_positif'))has-error @endif">
					  {!! Form::label('malaria_positif', 'Malaria Positif', ['class' => 'control-label']) !!}
					  {!! Form::select('malaria_positif', $confirms, 2, ['class' => 'form-control'])!!}
					  @if($errors->has('malaria_positif'))<code>{{ $errors->first('malaria_positif') }}</code>@endif
					</div>
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					
					<div class="form-group @if($errors->has('malaria_dikasih_obat'))has-error @endif">
					  {!! Form::label('malaria_dikasih_obat', 'Malaria Dikasih Obat', ['class' => 'control-label']) !!}
					  {!! Form::select('malaria_dikasih_obat', $confirms, 2, ['class' => 'form-control'])!!}
					  @if($errors->has('malaria_dikasih_obat'))<code>{{ $errors->first('malaria_dikasih_obat') }}</code>@endif
					</div>
	            </div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					
					<div class="form-group @if($errors->has('malaria_dikasih_kelambu'))has-error @endif">
					  {!! Form::label('malaria_dikasih_kelambu', 'Malaria Dikasih Kelambu', ['class' => 'control-label']) !!}
					  {!! Form::select('malaria_dikasih_kelambu', $confirms, 2, ['class' => 'form-control'])!!}
					  @if($errors->has('malaria_dikasih_kelambu'))<code>{{ $errors->first('malaria_dikasih_kelambu') }}</code>@endif
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
				
				<div class="form-group @if($errors->has('tbc_diperiksa_dahak'))has-error @endif">
				  {!! Form::label('tbc_diperiksa_dahak', 'TBC Diperiksa Dahak', ['class' => 'control-label']) !!}
				  {!! Form::select('tbc_periksa_dahak', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('tbc_diperiksa_dahak'))<code>{{ $errors->first('tbc_diperiksa_dahak') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('tbc_positif'))has-error @endif">
				  {!! Form::label('tbc_positif', 'TBC Positif', ['class' => 'control-label']) !!}
				  {!! Form::select('tbc_positif', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('tbc_positif'))<code>{{ $errors->first('tbc_positif') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				
				<div class="form-group @if($errors->has('tbc_dikasih_obat'))has-error @endif">
				  {!! Form::label('tbc_dikasih_obat', 'TBC Dikasih Obat', ['class' => 'control-label']) !!}
				  {!! Form::select('tbc_dikasih_obat', $confirms, 2, ['class' => 'form-control'])!!}
				  @if($errors->has('tbc_dikasih_obat'))<code>{{ $errors->first('tbc_dikasih_obat') }}</code>@endif
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

				<div class="form-group @if($errors->has('nama_perujuk'))has-error @endif">
				  {!! Form::label('nama_perujuk', 'Nama') !!}
				  {!! Form::text('nama_perujuk' , null, ['class' => 'form-control', 'id' => 'nama_perujuk']) !!}
				  @if($errors->has('nama_perujuk'))<code>{{ $errors->first('nama_perujuk') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('alamat_perujuk'))has-error @endif">
				  {!! Form::label('alamat_perujuk', 'Alamat') !!}
				  {!! Form::textarea('alamat_perujuk' , null, ['class' => 'form-control textareacustom', 'id' => 'alamat_perujuk']) !!}
				  @if($errors->has('alamat_perujuk'))<code>{{ $errors->first('alamat_perujuk') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<div class="form-group @if($errors->has('no_telp_perujuk'))has-error @endif">
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

