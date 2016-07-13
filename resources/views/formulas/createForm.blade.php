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
                            <div class="form-group">
                                {!!Form::label('merek')!!}<br />
                                {!!Form::text('merek', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Merek',
                                    'id'            => 'merek'
                                ))!!}
                                @if($errors->first('merek'))
                                <code>{!! $errors->first('merek')!!}</code>
                                @endif
                            </div>
                        </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            {!!Form::label('indikasi')!!}<br />
                            {!!Form::textarea('indikasi', null, array(
                                'class'         => 'form-control textareacustom',
                                'placeholder'   => 'Indikasi'
                            ))!!}
                            @if($errors->first('indikasi'))first('indikasi'))
                                <code>{!! $errors->first('indikasi')!!}</code>
                            @endif
                        </div>
                    </div>
                     <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            {!!Form::label('kontraindikasi')!!}<br />
                            {!!Form::textarea('kontraindikasi', null, array(
                                'class'         => 'form-control textareacustom',
                                'placeholder'   => 'kontraindikasi'
                            ))!!}
                            @if($errors->first('kontraindikasi'))
                            <code>{!! $errors->first('kontraindikasi')!!}</code>
                            @endif
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                {!!Form::label('efek_samping')!!}<br />
                                {!!Form::textarea('efek_samping', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'efek_samping'
                                ))!!}
                                @if($errors->first('efek_samping'))
                                <code>{!! $errors->first('efek_samping')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                {!!Form::label('harga_jual')!!}<br />
                                {!!Form::text('harga_jual', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Harga Jual'
                                ))!!}
                                @if($errors->first('harga_jual'))
                                <code>{!! $errors->first('harga_jual')!!}</code>
                                @endif
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                {!!Form::label('harga_beli')!!}<br />
                                {!!Form::text('harga_beli', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'harga_beli'
                                ))!!}
                                @if($errors->first('harga_beli'))
                                <code>{!! $errors->first('harga_beli')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                           <div class="form-group">
                                {!!Form::label('dijual_bebas')!!}<br />
                                {!!Form::select('dijual_bebas', $dijual_bebas, null, array(
                                    'class'         => 'form-control',
                                ))
                                !!}
                                @if($errors->first('dijual_bebas'))
                                <code>{!! $errors->first('dijual_bebas') !!}</code>
                                @endif
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                {!!Form::label('rak_id')!!}<br />
                                {!!Form::text('rak_id', null, array(
                                    'class'         => 'form-control',
                                    'placeholder'   => 'Kode Rak',
                                    'id'            => 'rak_id'
                                ))!!}
                                @if($errors->first('rak_id'))
                                <code>{!! $errors->first('rak_id')!!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                {!!Form::label('exp_date')!!}<br />
                                {!!Form::text('exp_date', null, array(
                                    'class'         => 'form-control tanggal',
                                    'placeholder'   => 'Harga Jual'
                                ))!!}
                                @if($errors->first('exp_date'))
                                <code>{!! $errors->first('exp_date')!!}</code>
                                @endif
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                    {!!Form::label('fornas')!!}<br />
                                    {!!Form::select('fornas', array(
                                        null        => '- Pilih -',
                                        '0'         => 'Bukan Fornas',
                                        '1'         => 'Fornas'
                                    ), null, array(
                                        'class'         => 'form-control',
                                    ))
                                    !!}
                                    @if($errors->first('fornas'))
                                    <code>{!! $errors->first('fornas') !!}</code>
                                    @endif
                            </div>
                        </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                {!!Form::label('sediaan')!!}<br />
                                {!!Form::select('sediaan', $sediaan, null, array(
                                    'class'         => 'form-control',
                                    'id'            => 'sediaan'
                                ))
                                !!}
                                @if($errors->first('sediaan'))
                                <code>{!! $errors->first('sediaan') !!}</code>
                                @endif
                                {!! Form::text('sediaan2', null, array('class' => 'form-control displayNone'))!!}
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            
                            <div class="form-group">
                                {!! Form::label('aturan_minum')!!}
                                {!! Form::select('aturan_minum_id', $aturan_minums, null, ['class'=>'selectpick', 'data-live-search' => 'true'])!!}
                            </div>
                        </div>
                     </div>
                    {{-- FORNAS HIDE --}}
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                         <div class="form-group" id="fornasHide">
                            {!!Form::label('alternatif_fornas')!!}<br />
                            {!!Form::select('alternatif_fornas', $alternatif_fornas, null, array(
                                'class'         => 'form-control selectpick',
                                'data-live-search' => 'true'
                            ))
                            !!}
                            @if($errors->first('alternatif_fornas'))
                            <code>{!! $errors->first('alternatif_fornas') !!}</code>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                             <div class="form-group" id="fornasHide">
                                {!!Form::label('peringatan')!!}<br />
                                {!!Form::textarea('peringatan', null, array(
                                    'class'         => 'form-control textareacustom',
                                    'placeholder'   => 'Peringatan'
                                ))
                                !!}
                                @if($errors->first('peringatan'))
                                <code>{!! $errors->first('peringatan') !!}</code>
                                @endif
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
