{!! Form::text('antrianperiksa', $antrianperiksa->id, ['class' => 'form-control hide']) !!}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
			<div class="panel-title">Gambar Periksa | {{ $antrianperiksa->pasien->nama }}</div>
			</div>
			<div class="panel-body">
				<div id="panel_gambar">
					@foreach($antrianperiksa->gambars as $k=> $image)	
						<div class="satu_gambar">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								  {!! Form::label('name', $image->nama , ['class' => 'control-label']) !!}
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<button class="btn btn-block btn-danger" type="button" onclick="delImage(this);return false;" value="{{ $image->id }}">hapus</button>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<img src="{{ \Storage::disk('s3')->url('img/estetika/' . $image->nama) }}" class="img-rounded upload" alt="Responsive image">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<strong>Keterangan gambar :</strong>	{{ $image->keterangan }}
								</div>
							</div>
							<hr />
						</div>
					@endforeach
				</div>
				@include('tambah_gambar')
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<button class="btn btn-success btn-block btn-lg" type="button" onclick="validasiKeterangan();return false;">Submit</button>
							{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
						</div> 
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-danger btn-block btn-lg" href="{{ url('poli/' . $antrianperiksa->id) }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::textarea('image_sisa', null, ['class' => 'form-control', 'id' => 'image_sisa']) !!}
