@include('raks.form', ['disabled' => false, 'readonly' => false, 'stokShow' => false])
     <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <button type="button" class="btn btn-primary btn-block" id="dummySubmitRak">Submit</button>
              {{ Form::submit('submit', ['class' => 'btn btn-primary btn-block displayNone', 'id' => 'submitOnRak'])}}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              @if($modal)
                  <a href="#" class="btn btn-warning btn-block" onclick='$("#newRak").modal("hide"); return false;'>Cancel</a>
              @else
                  {{ HTML::link('formulas/' . $formula->id, 'Cancel', ['class' => 'btn btn-warning btn-block']) }}
              @endif
            </div>
            </div>
          </div>
        </div>
        </div>
         <div class="col-lg-6 col-md-6">
           <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Formula</h3>
          </div>
          <div class="panel-body">
                <table class="table table-bordered table-hover" id="tableAsuransi">
                    <tbody>
                    <tr>
                      <th>dijual_bebas</th>
                        <td>
                          @if($formula->dijual_bebas == '1')
                            Ya
                          @else
                            Tidak
                          @endif
                        </td> 
                      </tr>
              <tr>
                <th>efek_samping</th>
                <td>{{ $formula->efek_samping }}</td> 
              </tr>
              <tr>
                <th>sediaan</th>
                <td>{{ $formula->sediaan }}</td> 
              </tr>
              <tr>
                <th>indikasi</th>
                <td>{{ $formula->indikasi }}</td> 
              </tr>
              <tr>
                <th>kontraindikasi</th>
                <td>{{ $formula->kontraindikasi }}</td> 
              </tr>
              <tr>
                <th>Komposisi</th>
                <td>
                  @foreach($formula->komposisi as $komp)
                    {{$komp->generik->generik}} {{$komp->bobot}}, 
                  @endforeach
              
                </td>
              </tr>
              <tr>
                <th>Merek</th>
                <td>
                  @foreach ($formula->rak as $rak)
                      @foreach ($rak->merek as $merek)
                        {{ $merek->merek }}, 
                      @endforeach
                  @endforeach
                </td> 
              </tr>
                    </tbody>
                </table>
          </div>
      </div>
  </div>
    </div>
  </div>
</div>