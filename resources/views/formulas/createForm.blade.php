<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">Formula - Rak - Merek</h3>
          </div>
          <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                     <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group @if($errors->has('merek'))has-error @endif">
							  {!! Form::label('merek', 'Merek', ['class' => 'control-label']) !!}
                                {!!Form::text('merek', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Merek',
                                    'id'            => 'merek'
                                ))!!}
							  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
							</div>
                        </div>
                    <div class="col-lg-12 col-md-12">
						<div class="form-group @if($errors->has('indikasi'))has-error @endif">
						  {!! Form::label('indikasi', 'Indikasi', ['class' => 'control-label']) !!}
                            {!!Form::textarea('indikasi', null, array(
                                'class'         => 'form-control textareacustom',
                                'placeholder'   => 'Indikasi'
                            ))!!}
						  @if($errors->has('indikasi'))<code>{{ $errors->first('indikasi') }}</code>@endif
						</div>
                    </div>
                     <div class="col-lg-12 col-md-12">
						 <div class="form-group @if($errors->has('kontraindikasi'))has-error @endif">
						   {!! Form::label('kontraindikasi', 'Kontra Indikasi', ['class' => 'control-label']) !!}
                            {!!Form::textarea('kontraindikasi', null, array(
                                'class'         => 'form-control textareacustom',
                                'placeholder'   => 'kontraindikasi'
                            ))!!}
						   @if($errors->has('kontraindikasi'))<code>{{ $errors->first('kontraindikasi') }}</code>@endif
						 </div>
                    </div>
					<div class="col-lg-12 col-md-12">
						 <div class="form-group @if($errors->has('golongan_obat'))has-error @endif">
						   {!! Form::label('golongan_obat', 'Golongan Obat', ['class' => 'control-label']) !!}
                            {!!Form::text('golongan_obat', null, array(
                                'class'         => 'form-control',
                                'placeholder'   => 'golongan_obat'
                            ))!!}
						   @if($errors->has('golongan_obat'))<code>{{ $errors->first('golongan_obat') }}</code>@endif
						 </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
							<div class="form-group @if($errors->has('efek_samping'))has-error @endif">
							  {!! Form::label('efek_samping', 'Efek Samping', ['class' => 'control-label']) !!}
                                {!!Form::textarea('efek_samping', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'efek_samping'
                                ))!!}
							  @if($errors->has('efek_samping'))<code>{{ $errors->first('efek_samping') }}</code>@endif
							</div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group @if($errors->has('harga_jual'))has-error @endif">
							   {!! Form::label('harga_jual', 'Harga Jual', ['class' => 'control-label']) !!}
                                {!!Form::text('harga_jual', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Harga Jual'
                                ))!!}
							   @if($errors->has('harga_jual'))<code>{{ $errors->first('harga_jual') }}</code>@endif
							 </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
							 <div class="form-group @if($errors->has('harga_beli'))has-error @endif">
							   {!! Form::label('harga_beli', 'Harga Beli', ['class' => 'control-label']) !!}
                                {!!Form::text('harga_beli', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'harga_beli'
                                ))!!}
							   @if($errors->has('harga_beli'))<code>{{ $errors->first('harga_beli') }}</code>@endif
							 </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<div class="form-group @if($errors->has('dijual_bebas'))has-error @endif">
							  {!! Form::label('dijual_bebas', 'Dijual Bebas', ['class' => 'control-label']) !!}
                                {!!Form::select('dijual_bebas', $dijual_bebas, null, array(
                                    'class'         => 'form-control',
                                ))
                                !!}
							  @if($errors->has('dijual_bebas'))<code>{{ $errors->first('dijual_bebas') }}</code>@endif
							</div>
                        </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group @if($errors->has('rak_id'))has-error @endif">
							   {!! Form::label('rak_id', 'Rak Id', ['class' => 'control-label']) !!}
                                {!!Form::text('rak_id', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Kode Rak',
                                    'id'            => 'rak_id'
                                ))!!}
							   @if($errors->has('rak_id'))<code>{{ $errors->first('rak_id') }}</code>@endif
							 </div>
                        </div>
                    </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group @if($errors->has('exp_date'))has-error @endif">
							   {!! Form::label('exp_date', 'Exp Date', ['class' => 'control-label']) !!}
                                {!!Form::text('exp_date', null, array(
                                    'class'         => 'form-control tanggal',
                                    'placeholder'   => 'Harga Jual'
                                ))!!}
							   @if($errors->has('exp_date'))<code>{{ $errors->first('exp_date') }}</code>@endif
							 </div>
                        </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group @if($errors->has('fornas'))has-error @endif">
							   {!! Form::label('fornas', 'Fornas', ['class' => 'control-label']) !!}
								{!!Form::select('fornas', array(
										null        => '- Pilih -',
										'0'         => 'Bukan Fornas',
										'1'         => 'Fornas'
									), null, array(
										'class'         => 'form-control',
									))
								!!}
							   @if($errors->has('fornas'))<code>{{ $errors->first('fornas') }}</code>@endif
							 </div>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							 <div class="form-group @if($errors->has('sediaan'))has-error @endif">
							   {!! Form::label('sediaan', 'Sediaan', ['class' => 'control-label']) !!}
                                {!!Form::select('sediaan', $sediaan, null, array(
										'class'         => 'form-control',
										'id'            => 'sediaan'
								))!!}
							   @if($errors->has('sediaan'))<code>{{ $errors->first('sediaan') }}</code>@endif
							 </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('aturan_minum'))has-error @endif">
							  {!! Form::label('aturan_minum', 'Aturan Minum', ['class' => 'control-label']) !!}
                              {!! Form::select('aturan_minum_id', $aturan_minums, null, ['class'=>'selectpick', 'data-live-search' => 'true'])!!}
							  @if($errors->has('aturan_minum'))<code>{{ $errors->first('aturan_minum') }}</code>@endif
							</div>
                        </div>
                     </div>
                    {{-- FORNAS HIDE --}}
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
						<div class="form-group @if($errors->has('alternatif_fornas'))has-error @endif" id="fornashide" >
						  {!! Form::label('alternatif_fornas', 'Alternatif Fornas', ['class' => 'control-label']) !!}
                            {!!Form::select('alternatif_fornas', $alternatif_fornas, null, array(
                                'class'         => 'form-control selectpick',
                                'data-live-search' => 'true'
                            ))
                            !!}
						  @if($errors->has('alternatif_fornas'))<code>{{ $errors->first('alternatif_fornas') }}</code>@endif
						</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
							<div class="form-group @if($errors->has('peringatan'))has-error @endif" id="fornashide">
							  {!! Form::label('peringatan', 'Peringatan', ['class' => 'control-label']) !!}
                                {!!Form::textarea('peringatan', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'Peringatan'
                                ))
                                !!}
							  @if($errors->has('peringatan'))<code>{{ $errors->first('peringatan') }}</code>@endif
							</div>
                        </div>
                    </div>
                </div>
            </div>
       
        </div>
        </div>
        </div>
        </div>
@include('formulas.form')
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {!! HTML::link('#', 'Submit', ['class' => 'btn btn-success btn-block', 'id' => 'dummySubmitFormula'])!!}
        {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block displayNone', 'id' => 'submitFormula'])!!}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        @if($modal)
            <a href="#" class="btn btn-danger btn-block" onclick="$('#modalNewFormula').modal('hide');return false;">Cancel</a>
        @else
            {!! HTML::link('formulas', 'Cancel', ['class' => 'btn btn-danger btn-block'])!!}
        @endif
    </div>
</div>
