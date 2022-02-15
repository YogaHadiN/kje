@if( isset( $kirim_berkas ) )
	@foreach($kirim_berkas->petugas_kirim as $k => $staf)	
		<div class="row">
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
					{!! Form::label('staf_id[]', 'Staf', ['class' => 'control-label']) !!}
					{!! Form::select('staf_id[]', $staf_list, $staf->staf_id, array(
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
					{!! Form::select('role_pengiriman_id[]', $role_pengiriman_list, $staf->role_pengiriman_id, array(
						'class'         => 'form-control role_pengiriman rq'
					))!!}
					@if($errors->has('role_pengiriman_id'))<code>{{ $errors->first('role_pengiriman_id') }}</code>@endif
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('', '', ['class' => 'control-label']) !!}
				@if( $k == $kirim_berkas->petugas_kirim->count() -1 )
					<button type="button" onclick="tambahStaf(this);return false;" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
				@else
					<button type="button" onclick="kurangStaf(this);return false;" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
				@endif
			</div>
		</div>
	@endforeach
@else
	@include('kirim_berkas.staf_form')
@endif
