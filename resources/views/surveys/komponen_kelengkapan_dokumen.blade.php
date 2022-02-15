@if ( $periksa->prolanis_dm )
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group{{ $errors->has('klaim_gdp_bpjs') ? ' has-error' : '' }}">
				{!! Form::label('klaim_gdp_bpjs', 'Klaim GDP BPJS') !!}
				{!! Form::file('klaim_gdp_bpjs', ['class' => 'rq']) !!}
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				{!! $errors->first('klaim_gdp_bpjs', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	</div>
@endif
@include('periksas.showForm')
