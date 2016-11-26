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
							@else
							<img src="{!! url( 'qrcode?text=' . $url . '/periksa/' . $periksaex->id . '/images/edit' ) !!}" alt="">
							@endif
						@else
							@if($antrianperiksa->gambars->count() < 1)
							<img src="{!! url( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images' ) !!}" alt="">
							@else
							<img src="{!! url( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images/edit' ) !!}" alt="">
							@endif
						@endif
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left blue-bg">
					<h2>Input Gambar</h2>
					<ul>
						<li>Pastikan Handphone menggunakan wifi kje</li>
						<li>Scan QR Code disamping dengan Smartphone</li>
						<li>Upload Image, Ambil Gambar, Submit</li>
						<li>Refersh halaman / Tekan F5 untuk melihat hasilnya dibawah ini</li>
					</ul>
			</div>
			</div>
				@if(isset($periksaex))
				@foreach($periksaex->gambars as $k=> $img)
					@if( !App\Classes\Yoga::even($k) )
						<div class="row">
					@endif
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<img src="{!! url( 'img/estetika/' . $img->nama ) !!}" alt="" class="upload img-rounded">
						<div class="alert alert-info">
							 {{ $img->keterangan }} 
						</div>
					</div>
					@if( !App\Classes\Yoga::even($k) )
						</div>
					@endif
					@endforeach
				@else
				@foreach($antrianperiksa->gambars as $k=> $img)
					@if( !App\Classes\Yoga::even($k) )
						<div class="row">
					@endif
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<img src="{!! url( 'img/estetika/' . $img->nama ) !!}" alt="" class="upload img-rounded">
						<div class="alert alert-info">
							 {{ $img->keterangan }} 
						</div>
					</div>
					@if( !App\Classes\Yoga::even($k) )
						</div>
					@endif
					@endforeach
				@endif
		</div>
	</div>
</div>
