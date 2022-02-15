<div class="panel panel-info">
	<div class="panel-body">
		<div class="form-group{{ $errors->has('faktur_image') ? ' has-error' : '' }}">
			{!! Form::label('faktur_image', 'Upload Gambar Faktur') !!}
			{!! Form::file('faktur_image') !!}
				@if (isset($pembelian) && $pembelian->faktur_image)
					<p> <img src="{{ \Storage::disk('s3')->url('img/belanja/obat/'.$pembelian->faktur_image) }}" alt="" class="img-rounded upload"> </p>
				@else
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				@endif
			{!! $errors->first('faktur_image', '<p class="help-block">:message</p>') !!}
		</div>	
	</div>
</div>
