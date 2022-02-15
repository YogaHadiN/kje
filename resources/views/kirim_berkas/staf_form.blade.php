<div class="row">
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
		<div class="form-group @if($errors->has('staf_id'))has-error @endif">
			{!! Form::label('staf_id[]', 'Staf', ['class' => 'control-label']) !!}
			{!! Form::select('staf_id[]', $staf_list, null, array(
				'class'            => 'form-control staf_id rq',
				'data-live-search' => 'true',
				'placeholder'      => 'Pilih Petugas'
			))!!}
			@if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
		<div class="form-group @if($errors->has('role_pengiriman_id'))has-error @endif">
			{!! Form::label('role_pengiriman_id', 'Peran', ['class' => 'control-label']) !!}
			{!! Form::select('role_pengiriman_id[]', $role_pengiriman_list, null, array(
				'class'         => 'form-control role_pengiriman rq'
			))!!}
			@if($errors->has('role_pengiriman_id'))<code>{{ $errors->first('role_pengiriman_id') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		{!! Form::label('', '', ['class' => 'control-label']) !!}
			<button type="button" onclick="tambahStaf(this);return false;" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	</div>
</div>
