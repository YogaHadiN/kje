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
							{!! Form::select('hamil_id', App\Classes\Yoga::hamil(), $hamil, ['class' => 'form-control', 'id' => 'hamil_id'])!!}
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
							{!! Form::select('jenis_rumah_sakit_id', App\Classes\Yoga::tipeRumahSakitList(), $jenis_rumah_sakit, ['class' => 'form-control', 'placeholder' => 'Sebisa mungkin pilih yang ada', 'id' => 'jenis_rumah_sakit'])!!}
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
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('alasan_rujuk'))has-error @endif">
						  {!! Form::label('alasan_rujuk', 'Alasan Rujuk', ['class' => 'control-label']) !!}
				 		  {!! Form::textarea('alasan_rujuk', null, ['class' => 'form-control textareacustom'])!!}
						  @if($errors->has('alasan_rujuk'))<code>{{ $errors->first('alasan_rujuk') }}</code>@endif
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
