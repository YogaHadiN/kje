{!! Form::text('periksa_id', $periksa->id, ['class' => 'form-control hide']) !!}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
			<div class="panel-title">Gambar Estetika | {{ $periksa->pasien->nama }}</div>
			</div>
			<div class="panel-body">
				<div id="panel_gambar">
					@foreach($periksa->gambarPeriksa as $image)	
						@include('gambar_periksa',['image' => $image])	
					@endforeach
				</div>
				@include('tambah_gambar')
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<button class="btn btn-success btn-block btn-lg" type="button" onclick="validasiKeterangan();return false;">Submit</button>
							{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
						</div> 
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger btn-block btn-lg" href="{{ url('antrianperiksas') }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
