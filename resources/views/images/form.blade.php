<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@if (Session::has('pesan'))
			{!! Session::get('pesan')!!}
		@endif
	</div>
</div>
{!! Form::text('periksa_id', $periksa->id, ['class' => 'form-control hide']) !!}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					@if($periksa->gambars->count() > 0)
						Edit
					@endif
					Gambar Periksa | {{ $periksa->pasien->nama }}</div>
			</div>
			<div class="panel-body">
				<div id="panel_gambar">
					@foreach($periksa->gambars as $k=> $image)	
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
									<img src="{{ url('img/estetika/' . $image->nama) }}" class="img-rounded upload" alt="Responsive image">
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
							@if($periksa->gambars->count() > 0)
							<button class="btn btn-success btn-block btn-lg" type="button" onclick="validasiKeterangan();return false;">Update</button>
						@else
							<button class="btn btn-success btn-block btn-lg" type="button" onclick="validasiKeterangan();return false;">Submit</button>
						@endif
							{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
						</div> 
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-danger btn-block btn-lg" href="{{ url('ruangperiksa/'. $periksa->poli) }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::textarea('image_sisa', null, ['class' => 'hide', 'id' => 'image_sisa']) !!}
