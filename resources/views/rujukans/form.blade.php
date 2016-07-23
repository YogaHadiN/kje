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
						<div class="form-group">
							<label for="">Pasien Hamil?</label>
							{!! Form::select('hamil_id', App\Classes\Yoga::hamil(), $hamil, ['class' => 'form-control', 'id' => 'hamil_id'])!!}
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
						<div class="form-group">
							{!! Form::label('hpht', 'HPHT (boleh di kira2)')!!}
							{!! Form::text('hpht', $hpht, ['class' => 'form-control tanggal inputObs', 'id' => 'HPHT'])!!}
						</div>
					</div>
				</div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<label for="">Spesialis</label>
							{!! Form::text('tujuan_rujuk', $tujuan_rujuk, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'tujuan_rujuk', 'onblur' => 'tujuanChange(this);return false;'])!!}
						</div>
				  	</div>
				 </div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<label for="">Tipe Tempat Rujuk</label>
							{!! Form::select('jenis_rumah_sakit_id', App\Classes\Yoga::tipeRumahSakitList(), $jenis_rumah_sakit, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'jenis_rumah_sakit'])!!}
						</div>
				  	</div>
				 </div>
			  	 <div class="row">
				  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<label for="">Rumah Sakit</label>
							{!! Form::text('rumah_sakit', $rumah_sakit, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'rumah_sakit', 'onblur' => 'rschange(this);return false;'])!!}
						</div>
				  	</div>
				 </div>
				 <div class="row">
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<label for="">Alasan Rujuk</label>
				 		{!! Form::textarea('alasan_rujuk', null, ['class' => 'form-control textareacustom'])!!}
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
							<a href="{{ url('rujukans/delete/' . $rujukan->id) }}" class="btn btn-danger btn-lg btn-block" onclick="return confirm('Anda yakin mau menghapus rujukan untuk {!! $periksa->pasien->nama!!} ?' );return false;">DELETE</a>

						</div>
					</div>
				 @endif
			  </div>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="info-ketersediaan">
		
	</div>
</div>
