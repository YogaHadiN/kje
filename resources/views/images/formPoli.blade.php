<div class="panel panel-default">
	<div class="panel-body text-center">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2>Scan disini untuk input gambar</h2>
						@if(isset($periksaex))
							@if($periksaex->gambars->count() < 1)
							<img src="{!! url( 'qrcode?text=' . $url . '/periksa/' . $periksaex->id . '/images' ) !!}" alt="">
							<p> <a class="" href="{{ url('periksa/' . $periksaex->id . '/images') }}">Create Gambar</a> </p>
							@else
							<img src="{!! url( 'qrcode?text=' . $url . '/periksa/' . $periksaex->id . '/images/edit' ) !!}" alt="">
							<p> <a class="" href="{{ url('periksa/' . $periksaex->id . '/images/edit') }}">Edit Gambar</a> </p>
							@endif
						@else
							@if($antrianperiksa->gambars->count() < 1)
							<img src="{!! url( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images' ) !!}" alt="">
							<p> <a class="" href="{{ url('antrianperiksa/' . $antrianperiksa->id . '/images') }}">Create Gambar</a> </p>
							@else
							<img src="{!! url( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images/edit' ) !!}" alt="">
							<p> <a class="" href="{{ url('antrianperiksa/' . $antrianperiksa->id . '/images/edit') }}">Edit Gambar</a> </p>
							@endif
						@endif
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				@if(isset($periksaex))
					@foreach($periksaex->gambars as $img)
						<img src="{!! url( 'img/estetika/' . $img->nama ) !!}" alt="" class="upload img-rounded">
						<div class="alert alert-info">
							 {{ $img->keterangan }} 
						</div>
					@endforeach
				@else
					@foreach($antrianperiksa->gambars as $img)
						<img src="{!! url( 'img/estetika/' . $img->nama ) !!}" alt="" class="upload img-rounded">
						<div class="alert alert-info">
							 {{ $img->keterangan }} 
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
