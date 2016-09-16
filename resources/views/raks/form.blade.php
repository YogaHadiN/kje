<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">Rak dengan Formula ID : <span id="ket_formula_id"> {{ $formula->id }} </span></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('id'))has-error @endif">
				    {!! Form::label('id', 'Kode Rak', ['class' => 'control-label']) !!}
                    {{ Form::text('id', null, ['class' => 'form-control', $readonly => $readonly, 'id'=>'idOnRak' ])}}
				    @if($errors->has('id'))<code>{{ $errors->first('id') }}</code>@endif
				  </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('formula_id'))has-error @endif">
				    {!! Form::label('formula_id', 'Kode Formula', ['class' => 'control-label']) !!}
                    {{ Form::text('formula_id', $formula->id, ['class' => 'form-control', 'readonly' => 'readonly', 'id'=>'formulaIdOnRak'])}}
				    @if($errors->has('formula_id'))<code>{{ $errors->first('formula_id') }}</code>@endif
				  </div>
            </div>
            </div>
            <div class="row">
              @if(!$disabled)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('merek'))has-error @endif">
					  {!! Form::label('merek', 'Merek', ['class' => 'control-label']) !!}
                        <div class="input-group">
                            {{ Form::text('merek', null, ['class' => 'form-control', $disabled => $disabled, 'id' => 'merekOnRak', 'dir' => 'rtl'])}}
                            <span class="input-group-addon" id="merekOnRakEndFix">{{ $formula->endfix }}</span>
                        </div>
					  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
					</div>
                </div>
                @endif
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  <div class="form-group @if($errors->has('alternatif_fornas'))has-error @endif">
				    {!! Form::label('alternatif_fornas', 'Alternatif Fornas', ['class' => 'control-label']) !!}
                    {{ Form::select('alternatif_fornas', $alternatif_fornas, null, ['class' => 'form-control selectpick', 'disabled' => 'disabled', 'id' => 'alternatifFornasOnRak', 'data-live-search' => 'true'])}}
				    @if($errors->has('alternatif_fornas'))<code>{{ $errors->first('alternatif_fornas') }}</code>@endif
				  </div>
              </div>
            </div>
              <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('exp_date'))has-error @endif">
				    {!! Form::label('exp_date', 'Exp Date', ['class' => 'control-label']) !!}
                    {{ Form::text('exp_date', null, ['class' => 'form-control tanggal', 'id' => 'expDateOnRak'])}}
				    @if($errors->has('exp_date'))<code>{{ $errors->first('exp_date') }}</code>@endif
				  </div>
            </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('fornas'))has-error @endif">
				    {!! Form::label('fornas', 'Fornas', ['class' => 'control-label']) !!}
                    {{ Form::select('fornas', $fornas, null, ['class' => 'form-control', 'id' => 'fornasOnRak'])}}
				    @if($errors->has('fornas'))<code>{{ $errors->first('fornas') }}</code>@endif
				  </div>
            </div>
            </div>
              <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('harga_beli'))has-error @endif">
				    {!! Form::label('harga_beli', 'Harga Beli', ['class' => 'control-label']) !!}
                    {{ Form::text('harga_beli', null, ['class' => 'form-control', 'id'=>'hargaBeliOnRak'])}}
				    @if($errors->has('harga_beli'))<code>{{ $errors->first('harga_beli') }}</code>@endif
				  </div>
            </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('harga_jual'))has-error @endif">
				    {!! Form::label('harga_jual', 'Harga Jual', ['class' => 'control-label']) !!}
                    {{ Form::text('harga_jual', null, ['class' => 'form-control', 'id'=>'hargaJualOnRak'])}}
				    @if($errors->has('harga_jual'))<code>{{ $errors->first('harga_jual') }}</code>@endif
				  </div>
            </div>
            </div>
            @if($stokShow)
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('stok'))has-error @endif">
						  {!! Form::label('stok', 'Stok', ['class' => 'control-label']) !!}
                          {{ Form::text('stok', null, ['class' => 'form-control', 'id'=>'stokOnRak'])}}
						  @if($errors->has('stok'))<code>{{ $errors->first('stok') }}</code>@endif
						</div>
                  </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('stok_minimal'))has-error @endif">
						  {!! Form::label('stok_minimal', 'Stok Minimal', ['class' => 'control-label']) !!}
                          {{ Form::text('stok_minimal', null, ['class' => 'form-control', 'id'=>'stokMinimalOnRak'])}}
						  @if($errors->has('stok_minimal'))<code>{{ $errors->first('stok_minimal') }}</code>@endif
						</div>
                  </div>
                </div>
            @endif
