<div class="panel panel-default">
  <div class="panel-body">
    <h1>Pilih Laporan Laba Rugi</h1>
    <hr>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  <div class="row">
		  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  		<div class="form-group @if($errors->has('periode'))has-error @endif">
		  			{!! Form::label('periode', 'Periode', ['class' => 'control-label']) !!}
		  			{!! Form::select('periode', $periode, null, array(
		  				'class'         => 'form-control',
		  				'onchange'         => 'periodeChange(this);return false;',
		  			))!!}
		  		  @if($errors->has('periode'))<code>{{ $errors->first('periode') }}</code>@endif
		  		</div>
		  	</div>
		  </div>
		  <div class="row rowBulan hide">
		  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  <div class="form-group @if($errors->has('bulan'))has-error @endif">
				{!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
				{!! Form::select('bulan', App\Models\Classes\Yoga::bulanList(), date('m'), ['class' => 'form-control']) !!}
				@if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
			  </div>
		  	</div>
		  </div>
		  <div class="row rowTahun hide">
		  	<div class="col-xs-12 col-sm-12	 col-md-12	 col-lg-12">
			  <div class="form-group @if($errors->has('tahun'))has-error @endif">
				{!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
				{!! Form::text('tahun', date('Y'), ['class' => 'form-control']) !!}
				@if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
			  </div>
		  	</div>
		  </div>
		  <div class="row rowSubmit hide">
		  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group">
				  <div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					  <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
					  <button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					  <a href="{{ url('laporan_laba_rugis') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
					</div>
				  </div>
				</div>
		  	</div>
		  </div>
      </div>
    </div>
  </div>
</div>
