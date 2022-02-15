<div class="barcode">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<button class="btn btn-info btn-block" type="button" onclick='refresh();return false;'>Refresh</button>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<a href="{{ url('antrianperiksa/'.  $antrianperiksa->id . '/images') }}">
				<img src="{{ $base64 }}" alt="">
			</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-success">
			<div class="panel-body">
				<h3>Gambar :</h3>
				<div id="gambar">
					
				</div>
			</div>
		</div>
	</div>
</div>


