<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-info">
			  <div class="panel-heading">
					<h3 class="panel-title">Pasien {!!$periksa->id!!} - {!! $periksa->pasien->nama !!}</h3>
			  </div>
			  <div class="panel-body">
		  		{!! Form::hidden('periksa_id', $periksa->id)!!}
		  		{!! Form::hidden('pasien_id', $periksa->pasien_id)!!}
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('hamil_id'))has-error @endif">
						  {!! Form::label('hamil_id', 'Pasien Hamil?', ['class' => 'control-label']) !!}
							{!! Form::select('hamil_id', App\Models\Classes\Yoga::hamil(), $hamil, ['class' => 'form-control', 'id' => 'hamil_id'])!!}
						  @if($errors->has('hamil_id'))<code>{{ $errors->first('hamil_id') }}</code>@endif
						</div>
				  	</div>
				 </div>
				 <div class="row" id="riwobs">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<label for="">Riwayat Obstetri</label>
							@include('antrianpolis.gpa', [
								'g' => $g,
								'p' => $p,
								'a' => $a
							])
						</div>
						<div class="form-group @if($errors->has('hpht'))has-error @endif">
						  {!! Form::label('hpht', 'HPHT (boleh di kira2)', ['class' => 'control-label']) !!}
							{!! Form::text('hpht', $hpht, ['class' => 'form-control tanggal inputObs', 'id' => 'HPHT'])!!}
						  @if($errors->has('hpht'))<code>{{ $errors->first('hpht') }}</code>@endif
						</div>
					</div>
				</div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('tujuan_rujuk'))has-error @endif">
						  {!! Form::label('tujuan_rujuk', 'Spesialis', ['class' => 'control-label']) !!}
							{!! Form::text('tujuan_rujuk', $tujuan_rujuk, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'tujuan_rujuk', 'onblur' => 'tujuanChange(this);return false;'])!!}
						  @if($errors->has('tujuan_rujuk'))<code>{{ $errors->first('tujuan_rujuk') }}</code>@endif
						</div>
				  	</div>
				 </div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('jenis_rumah_sakit_id'))has-error @endif">
						  {!! Form::label('jenis_rumah_sakit_id', 'Tipe Tempat Rujuk', ['class' => 'control-label']) !!}
							{!! Form::select('jenis_rumah_sakit_id', App\Models\Classes\Yoga::tipeRumahSakitList(), $jenis_rumah_sakit, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'jenis_rumah_sakit'])!!}
						  @if($errors->has('jenis_rumah_sakit_id'))<code>{{ $errors->first('jenis_rumah_sakit_id') }}</code>@endif
						</div>
				  	</div>
				 </div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('rumah_sakit'))has-error @endif">
						  {!! Form::label('rumah_sakit', 'Rumah Sakit', ['class' => 'control-label']) !!}
							{!! Form::text('rumah_sakit', $rumah_sakit, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'rumah_sakit', 'onblur' => 'rschange(this);return false;'])!!}
						  @if($errors->has('rumah_sakit'))<code>{{ $errors->first('rumah_sakit') }}</code>@endif
						</div>
				  	</div>
				 </div>
				 <div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="form-group @if($errors->has('diagnosa_id'))has-error @endif">
							<label for="diagnosa_id" id="lblDiagnosa" class="control-label" data-placement="left"  data-toggle="popover" title="Popover title" data-content="Jika ASMA BERAT, berikan bersama dexa inj IV 2 ampul, dan prednison dosis tinggi, Decafil 20 tablet, termasuk untuk pasien BPJS">Diagnosa</label><br />
								<div class="input-group">
								{!! Form::select('diagnosa_id', $diagnosa, $periksa->diagnosa_id, [
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
				 @if( $periksa->asuransi_id == '32' )
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<h2>Alasan Merujuk Pasien </h2>
							<h3>(Khusus Pasien BPJS)</h3>
							<div class="alert alert-success">
								Mohon kerjasamanya dokter mengisi alasan merujuk sesuai kolom yang disediakan. Boleh diisi salah satu saja atau lebih.
								Kalau bingung mau isi yang mana isi saja complication. <strong>Contoh salah : Perlu Penanganan Lebih Lanjut</strong>
							</div>
							
							<hr />
						</div>
					</div>
				 	<div class="row">
				 		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 			<div class="form-group @if($errors->has('time'))has-error @endif">
				 			  {!! Form::label('time', 'Time', ['class' => 'control-label']) !!}
							  {!! Form::textarea('time' , null, ['class' => 'form-control tacustom2', 'placeholder' => 'Alasan kronis atau lama berlangsungnya penyakit yang membuat pasien tidak bisa ditangani di klinik, Contoh : 1. Tekanan darah tinggi kronis,  2. DM tipe 2 kronis sudah observasi 1 bulan']) !!}
				 			  @if($errors->has('time'))<code>{{ $errors->first('time') }}</code>@endif
				 			</div>
				 		</div>
				 	</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('age'))has-error @endif">
							  {!! Form::label('age', 'Age', ['class' => 'control-label']) !!}
							  {!! Form::textarea('age' , null, ['class' => 'form-control tacustom2', 'placeholder' => 'Alasan umur pasien yang membuat pasien tidak bisa ditangani di klinik, Contoh : 1. Usia pasien terlalu kecil untuk diambil darahnya, 2. Demam pada bayi kurang dari 3 minggu, suspek sepsis']) !!}
							  @if($errors->has('age'))<code>{{ $errors->first('age') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('comorbidity'))has-error @endif">
							  {!! Form::label('comorbidity', 'Comorbidity', ['class' => 'control-label']) !!}
							  {!! Form::textarea('comorbidity' , null, ['class' => 'form-control tacustom2' , 'placeholder' => 'Alasan penyakit penyerta yang membuat pasien tidak bisa ditangani di klinik']) !!}
							  @if($errors->has('comorbidity'))<code>{{ $errors->first('comorbidity') }}</code>@endif
							</div>
						</div>
					</div>
				 @endif
				 <div class="row">
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('complication'))has-error @endif">
							@if($periksa->asuransi_id == '32')
							  {!! Form::label('complication', 'Complication', ['class' => 'control-label']) !!}
							  {!! Form::textarea('complication', null, ['class' => 'form-control tacustom2', 'placeholder' => 'Alasan beratnya penyakit  yang membuat pasien tidak bisa ditangani di klinik, Contoh : 1. Demam Berdarah, 2. Asma persisten, kambuh 3 x seminggu, 3. Gagal Jantung kronis tidak respon dengan pengobatan oral, 4. Tifoid fever tidak respons dengan pengobatan dengan Levofloxacine 1 x 500 mg 5 hari '])!!}
						    @else
							  {!! Form::label('complication', 'Alasan Rujuk', ['class' => 'control-label']) !!}
							  {!! Form::textarea('complication', null, ['class' => 'form-control tacustom2'])!!}
							@endif

						  @if($errors->has('complication'))<code>{{ $errors->first('complication') }}</code>@endif
						</div>
				 	</div>
				 </div>
				 <hr>
				 <div class="row">
				 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 		<button type="button" class="btn btn-primary btn-block" id="dummySubmit">Submit</button>
				 		{!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block hide', 'id' => 'submit'])!!}
				 	</div>
				 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 		{!! HTML::link('ruangperiksa/' . $periksa->poli, 'Cancel', ['class' => 'btn btn-warning btn-block'])!!}
				 	</div>
				 </div>
				 @if($periksa->asuransi_id == '3')
				 <div class="row">
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 		<div class="alert alert-danger">
							<h1>PERHATIAN</h1>
							<p>
								Merujuk Pasien INHEALTH harus diberikan obat sementara, bisa berupa vitamin bila bingung obat apa yang ingin diberikan
							</p>
				 		</div>
				 	</div>
				 </div>
				 @endif
				 @if($delete)
				 <br>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<a href="{{ url('rujukans/delete/' . $rujukan->id . '/' . $poli) }}" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Anda yakin mau menghapus rujukan untuk {!! $periksa->pasien->nama!!} ?' );return false;">DELETE</a>
						</div>
					</div>
				 @endif
			  </div>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="diagnosa">
			@if($periksa->diagnosa->harusDitangani)
				<div class="alert alert-danger">
					<h3>Diagnosa Tidak Boleh Dirujuk</h3>
					<ul>
						<li>Harap berikan Alasan yang kuat kenapa pasien harus dirujuk, karena seharusnya pasien bisa ditangani di klinik</li>
						<li>Atau ganti Diagnosa yang bisa dirujuk</li>
					</ul>

					
				</div>

			@endif
		</div>
		<div id="info-ketersediaan">
		</div>
		
	</div>
</div>
