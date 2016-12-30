
@if( !isset($kedua) )
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
			  {!! Form::label('nomor_faktur', 'Nomor Faktur', [
				  'class' => 'control-label'
			  ]) !!}
			  {!! Form::text('nomor_faktur' , null, [
				  'class' => 'form-control rq nomor_faktur_serviceAc',
				  'onkeyup' => 'nomorFakturServiceAcKeyup(this);return false;',
			  ]) !!}
			  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
			</div>
		</div>
	</div>
@endif
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('ac_id'))has-error @endif">
			@if( !isset($kedua) )
		  {!! Form::label('ac_id', 'AC yang diservice', ['class' => 'control-label']) !!}
			  @endif
		  {!! Form::select('ac_id' , App\Ac::list(), null, ['class' => 'form-control selectServiceAc rq', 'onchange' => 'selectServiceAcChange(this); return false;']) !!}
		  @if($errors->has('ac_id'))<code>{{ $errors->first('ac_id') }}</code>@endif
		</div>
	</div>

	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="form-group">
			@if( !isset($kedua) )
				{!! Form::label('', '', ['class' => 'control-label padding']) !!}
			@endif
			<div class="input-group nowrap">
				<button class="btn btn-primary key" value="0" type="button" onclick="tambahServiceAc(this);return false;"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
				<button class="btn btn-danger hide" type="button" onclick="kurangServiceAc(this);return false;"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>
			</div>
		</div>
	</div>

</div>
