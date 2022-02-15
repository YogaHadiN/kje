		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title">Informasi Pemeriksaan</div>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<tbody>
									<tr>
										<th class='text-left'>NamaA</th>
										<td>{{ $ap->pasien->nama }}</td>
										{{-- <td>{{ $ap->pasien->nama }}</td> --}}
									</tr>
									<tr>
										<th class='text-left'>Pembayaran</th>
										<td>{{ $ap->asuransi->nama }}</td>
									</tr>
									<tr>
										<th class='text-left'>Dokter Yang Menangani</th>
										<td>{{ $ap->staf->nama }}</td>
									</tr>
									<tr>
										<th class='text-left'>Alamat Pasien</th>
										<td>{{ $ap->pasien->alamat }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Riwayat Pengantar</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered">
								<thead>
									<tr>
										<th>Nama Pengantar</th>
										<th>Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									@foreach($riwayat as $r)
										<tr>
											<td>
												<a href="{{ url('pasiens/' . $r->pengantar_id . '/edit') }}" target="_blank">{{ ucfirst( $r->nama_pengantar ) }}</a>
											</td>
											<td>
												{{ $r->tanggal_lahir }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="panel-title">Pengantar</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="table_pengantar" class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>Pengantar</th>
									<th>Kartu BPJS</th>
									<th>KTP</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="viewJson">

							</tbody>
						</table>
					</div>
						{!! Form::textarea('jsonArray',$pengantars, ['class' => 'form-control hide', 'id' => 'jsonArray']) !!}
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-success btn-block btn-lg" type="button" @if($pengantar) onclick="dummyButton();return false;" @endif >Submit</button> 
								 {!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit']) !!}
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a class="btn btn-danger btn-block btn-lg" href="
								">Tidak Ada Pengantar</a> 
							</div>
						</div>
					{!! Form::text('full_url', null, ['class' => 'form-control']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	<div>
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#cariPasien" aria-controls="cariPasien" role="tab" data-toggle="tab" id='tabCariPasien'>Cari Pasien</a></li>
		<li role="presentation"><a href="#buatPasien" aria-controls="buatPasien" role="tab" data-toggle="tab">Buat Pasien</a></li>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="cariPasien">
		@include('pasiens.form', ['pengantar' =>true, 'createLink' =>false])
		</div>
		<div role="tabpanel" class="tab-pane" id="buatPasien">
			{!! Form::open(['url' => 'antrianpolis/ajax/pasien/create', 'method' => 'post', 'id' => 'pengantar_pasien_create']) !!}
					@include('pasiens.createForm', [
						'antrianpolis' => false,
						'pengantar' => true,
						'alamatPasien' => $ap->pasien->alamat
					])
			{!! Form::close() !!}
		</div>
	  </div>
	
	</div>
	<div class="row hide" id="tempForm">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group{{ $errors->has('kartu_bpjs') ? ' has-error' : '' }}">
				{!! Form::label('kartu_bpjs', 'Kartu BPJS', ['class' => 'control-label']) !!}
				{!! Form::file('kartu_bpjs[]', ['class' => 'form-control']) !!}
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				{!! $errors->first('kartu_bpjs', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>
	<div class="row hide" id="tempKTP">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group{{ $errors->has('kartu_bpjs') ? ' has-error' : '' }}">
				{!! Form::label('ktp', 'KTP', ['class' => 'control-label']) !!}
				{!! Form::file('ktp[]', ['class' => 'form-control']) !!}
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				{!! $errors->first('ktp', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>
