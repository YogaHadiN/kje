<div id="container_image" class="hide">
	<div class="row inputGambar">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group{{ $errors->has('tampak_depan') ? ' has-error' : '' }}">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						{!! Form::label('foto_estetika[]', 'Foto') !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-danger btn-block" type="button" onclick='hapusGambar(this);return false;'>Hapus Gambar</button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!! Form::file('foto_estetika[]') !!}
							@if (isset($image))
								<p> {!! HTML::image(asset('img/estetika/'.$image->nama), null, ['class'=>'img-rounded upload']) !!} </p>
							@else
								<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
							@endif
						{!! $errors->first('tampak_depan', '<p class="help-block">:message</p>') !!}
						{!! Form::text('id_estetika[]', null, ['class' => 'hide']) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('keterangan_gambar[]'))has-error @endif">
			  {!! Form::label('keterangan_gambar[]', 'Ketarangan Gambar', ['class' => 'control-label']) !!}
			  {!! Form::text('keterangan_gambar[]' , null, ['class' => 'form-control required']) !!}
			  @if($errors->has('keterangan_gambar[]'))<code>{{ $errors->first('keterangan_gambar[]') }}</code>@endif
			</div>
		</div>
	</div>
</div>
