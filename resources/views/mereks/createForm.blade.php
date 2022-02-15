<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">Input Merek</h3>
          </div>
          <div class="panel-body">
           <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('merek'))has-error @endif">
				  {!! Form::label('merek', 'Merek Baru', ['class' => 'control-label']) !!}
                  <div class="input-group">
                      {!! Form::text('merek', null, ['class' => 'form-control', 'aria-describedby'=> "addonMerek", 'dir' => 'rtl', 'id' => 'merekOnMerek'])!!}
                      <span class="input-group-addon" id="addonMerek">{!! $rak->formula->endfix !!}</span>
                  </div>
				  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
				</div>
              </div>
              </div>
           <div class="row HIDE">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('rak_id'))has-error @endif">
				  {!! Form::label('rak_id', 'Rak Id', ['class' => 'control-label']) !!}
				  {!! Form::text('rak_id', $rak->id, ['class' => 'form-control', 'id' => 'rakIdOnMerek', 'readonly' => 'readonly'])!!}
				  @if($errors->has('rak_id'))<code>{{ $errors->first('rak_id') }}</code>@endif
				</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group @if($errors->has('endfix'))has-error @endif">
				  {!! Form::label('endfix', 'End Fix', ['class' => 'control-label']) !!}
				  {!! Form::text('endfix', $rak->formula->endfix, ['class' => 'form-control', 'id'=>'endFixOnMerek', 'readonly' => 'readonly'])!!}
				  @if($errors->has('endfix'))<code>{{ $errors->first('endfix') }}</code>@endif
				</div>
            </div>
           	</div>
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <button type="button" class="btn btn-primary btn-block" id="dummySubmitMerek">Submit</button>
              {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block displayNone', 'id' => 'submitOnMerek'])!!}
            </div>
  
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              @if($modal)
                  <a href="#" class="btn btn-warning btn-block" onclick="$('#newMerek').modal('hide'); return false;">Cancel</a>
              @else
                  {!! HTML::link('formulas/' . $rak->formula->id, 'Cancel', ['class' => 'btn btn-warning btn-block']) !!}
              @endif
            </div>
            </div>
            </div>
            </div>

        </div>
         <div class="col-lg-6 col-md-6">
           <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Informasi</h3>
          </div>
          <div class="panel-body">
			  <div class="table-responsive">
					<table class="table table-bordered table-hover" id="tableAsuransi">
						<tbody>
					  <tr>
						<th>Merek</th>
						<td> 

						  @foreach ($rak->merek as $mrk)
						   -  {!! $mrk->merek !!} <br>
						   @endforeach 

						</td>
					  </tr> 
						<tr>
						  <th>Komposisi</th>
							<td>
							  @foreach($rak->formula->komposisi as $komp)
								{!!$komp->generik->generik!!} {!!$komp->bobot!!} <br>
							  @endforeach
							</td>
						</tr>
					<tr>
					  <th>Harga Beli</th>
					  <td class="uang">Rp. {!! $rak->harga_beli !!},- </td>
					</tr> 
					<tr>
					  <th>Harga Jual</th>
					  <td class="uang">Rp.  {!! $rak->harga_jual !!},- </td>
					</tr> 
					<tr>
					  <th>ID FORMULA</th>
					  <td> {!! $rak->formula_id !!} </td>
					</tr> 
					<tr>
					  <th>ID RAK</th>
					  <td> {!! $rak->id !!} </td>
					</tr> 
						 
					  </tbody>
					</table>
			  </div>
          </div>
      </div>
  </div>
    </div>
  </div>
</div>
