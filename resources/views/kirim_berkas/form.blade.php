	@include('kirim_berkas.staf_form_edit')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('tanggal'))has-error @endif">
			  {!! Form::label('tanggal', 'Tanggal Pengiriman', ['class' => 'control-label']) !!}
			  @if( isset($kirim_berkas) )
				  {!! Form::text('tanggal', $kirim_berkas->tanggal->format('d-m-Y'), array(
					'class'         => 'form-control rq tanggal'
				))!!}
			  @else
				{!! Form::text('tanggal', date('d-m-Y'), array(
					'class'         => 'form-control rq tanggal'
				))!!}
			  @endif
			  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('alamat'))has-error @endif">
			  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
				{!! Form::textarea('alamat', null, array(
					'class'         => 'form-control rq textareacustom'
				))!!}
			  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
			</div>
		</div>
	</div>
	@if( isset($kirim_berkas) )
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
					  {!! Form::label('foto_berkas_dan_bukti', 'Foto bukti pengesahan', ['class' => 'control-label']) !!}
						@if (isset($kirim_berkas) && $kirim_berkas->foto_berkas_dan_bukti)
							<p> <img src="{{ \Storage::disk('s3')->url('img/foto_berkas_dan_bukti/'.$kirim_berkas->foto_berkas_dan_bukti) }}" alt="" class="img-rounded upload"> </p>
						@else
							<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
					  {!! Form::label('pengeluaran', 'Bukti Faktur', ['class' => 'control-label']) !!}
					  @if (isset($kirim_berkas->pengeluaran_id) && $kirim_berkas->pengeluaran->faktur_image)
						  <p> <img src="{{ \Storage::disk('s3')->url('img/belanja/lain/'.$kirim_berkas->pengeluaran->faktur_image) }}" alt="" class="img-rounded upload"> </p>
						@else
							<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					</div>
				</div>
			</div>
		</div>
	@endif
	<div class="panel panel-default">
		<div class="panel-body">
			<h3>Hasil : </h3>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama Asuransi</th>
							<th>Jumlah Tagihan</th>
							<th>Total Tagihan</th>
						</tr>
					</thead>
					<tbody id="rekap_pengecekan">

					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					@if(isset($kirim_berkas))
						<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
					@else
						<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
					@endif
					{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row hide">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('name'))has-error @endif">
			  {!! Form::label('name', 'Nama', ['class' => 'control-label']) !!}
			  @if( isset( $kirim_berkas ) )
				  <textarea name="piutang_tercatat" id="piutang_tercatat" rows="8" cols="40">{{ $kirim_berkas->piutang_tercatat }}</textarea>
			  @else
				<textarea name="piutang_tercatat" id="piutang_tercatat" rows="8" cols="40">[]</textarea>
			  @endif
			  @if($errors->has('name'))<code>{{ $errors->first('name') }}</code>@endif
			</div>
		</div>
	</div>
